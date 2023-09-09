<?php

namespace ExequielLares\OrderExport\Plugin;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use ExequielLares\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;

class LoadExportDetailsIntoOrder
{

    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private OrderExportDetailsInterfaceFactory $orderExportDetailsFactory;

    public function __construct(
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
    )
    {
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @param int $orderId
     * @return mixed
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order, int $orderId): OrderInterface
    {
        /** @var \Magento\Sales\Api\Data\OrderExtensionInterface $extAttr */
        $extAttr = $order->getExtensionAttributes();
        $exportDetails = $extAttr->getExportDetails();
        if ($exportDetails) {
            return $order;
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('order_id', $orderId)
            ->create();

        $searchResults = $this->orderExportDetailsRepository->getList($searchCriteria);
        $items = $searchResults->getItems();
        $totalCount = $searchResults->getTotalCount();
        if ($totalCount > 0) {
            $exportDetails = reset($items);
        } else {
            $exportDetails = $this->orderExportDetailsFactory->create();
        }
        $extAttr->setExportDetails($exportDetails);

        return $order;
    }
}
