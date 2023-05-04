<?php

namespace ExequielLares\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Model\Config;
use Magento\Store\Model\ScopeInterface;

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
     */
    public function execute(array $orderExportData, OrderInterface $order): bool
    {
        $apiUrl = $this->config->getApiUrl(ScopeInterface::SCOPE_STORE, $order->getStoreId());
        $apiToken = $this->config->getApiToken(ScopeInterface::SCOPE_STORE, $order->getStoreId());

        // TODO: Enviar HTTP request al webservice

        return true;
    }
}
