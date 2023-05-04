<?php

namespace ExequielLares\OrderExport\Action;

use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Model\Config;
use Magento\Store\Model\ScopeInterface;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SendOrderDataToWebservice
 * @package ExequielLares\OrderExport\Action
 */
class SendOrderDataToWebservice
{

    /**
     * @var Config
     */
    private Config $config;
    private LoggerInterface $logger;

    /**
     * @param Config $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        LoggerInterface $logger
    )
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param array $orderExportData
     * @param OrderInterface $order
     * @return bool
     */
    public function execute(array $orderExportData, OrderInterface $order): bool
    {
        $apiUrl = $this->config->getApiUrl(ScopeInterface::SCOPE_STORE, $order->getStoreId());
        $apiToken = $this->config->getApiToken(ScopeInterface::SCOPE_STORE, $order->getStoreId());

        // Use GuzzleHttp (http://docs.guzzlephp.org/en/stable/) to send the data to our webservice.
        $client = new Client();
        $options = [
            'headers' => [
                'Content-Type' => 'appication/json',
                'Authorization' => 'Bearer ' . $apiToken,
            ],
            'verify' => $this->config->isSslVerificationEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId()),
            'body' => \json_encode($orderExportData),
        ];
        try {
            $response = $client->post($apiUrl, $options);
            $this->processResponse($response);
        } catch (GuzzleException | LocalizedException $e) {
           $this->logger->error($e->getMessage(),[
               'details' => $orderExportData
           ]);
           throw $e;
        }

        return true;
    }

    /**
     * @param ResponseInterface $response
     * @return void
     * @throws LocalizedException
     */
    private function processResponse(ResponseInterface $response): void
    {
        $responseBody = (string) $response->getBody();
        try {
            $responseData = \json_decode($responseBody, true);
        } catch (\Exception $e) {
            $responseData = [];
        }

        $success = $responseData['success'] ?? false;
        $errorMsg = __($responseData['message']) ?? __('There was a problem: %1', $responseBody);

        if ($response->getStatusCode() !== 200 || !$success) {
            throw new LocalizedException($errorMsg);
        }

    }

}
