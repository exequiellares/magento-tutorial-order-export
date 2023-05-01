<?php

namespace ExequielLares\OrderExport\Action;

use ExequielLares\OrderExport\Model\HeaderData;
use ExequielLares\OrderExport\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;

/**
 *
 */
class ExportOrder
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var CollectOrderData
     */
    private CollectOrderData $collectOrderData;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param CollectOrderData $collectOrderData
     * @param Config $config
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CollectOrderData $collectOrderData,
        Config $config
    ) {

        $this->orderRepository = $orderRepository;
        $this->collectOrderData = $collectOrderData;
        $this->config = $config;
    }

    /**
     * @param int $orderId
     * @param HeaderData $headerData
     * @return array
     * @throws LocalizedException
     */
    public function execute(int $orderId, HeaderData $headerData): array
    {
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException(__('Order export is disabled'));
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);
        // TODO: exportar al web service y guardar export details en la DB

        return $results;
    }
}
