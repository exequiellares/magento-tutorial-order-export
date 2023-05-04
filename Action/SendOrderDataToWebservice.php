<?php

namespace ExequielLares\OrderExport\Action;

use GuzzleHttp\Exception\GuzzleException;
use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Model\Config;
use Magento\Store\Model\ScopeInterface;
use GuzzleHttp\Client;

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

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }

    /**
     * @param array $orderExportData
     * @param OrderInterface $order
     * @return bool
     * @throws GuzzleException
     */
    public function execute(array $orderExportData, OrderInterface $order): bool
    {
        $apiUrl = $this->config->getApiUrl(ScopeInterface::SCOPE_STORE, $order->getStoreId());
        $apiToken = $this->config->getApiToken(ScopeInterface::SCOPE_STORE, $order->getStoreId());

        $client = new Client();
        $options = [
            'headers' => [
                'Content-Type' => 'appication/json',
                'Authorization' => 'Bearer ' . $apiToken,
            ],
            'verify' => $this->config->isSslVerificationEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId()),
            'body' => json_encode($orderExportData),
        ];
        $client->post($apiUrl, $options);

        return true;
    }
}
