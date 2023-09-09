<?php

namespace ExequielLares\OrderExport\Action;

use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;

/**
 * Class SaveExportDetailsToOrder
 */
class SaveExportDetailsToOrder
{

    /**
     * @var OrderExportDetailsInterfaceFactory
     */
    private OrderExportDetailsInterfaceFactory $orderExportDetailsFactory;
    /**
     * @var OrderExportDetailsRepositoryInterface
     */
    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;

    /**
     * @param OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
     * @param OrderExportDetailsRepositoryInterface $orderExportDetailsRepository
     */
    public function __construct(
        OrderExportDetailsInterfaceFactory $orderExportDetailsFactory,
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository
    )
    {
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
    }

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @param array $results
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(OrderInterface $order, HeaderData $headerData, array $results): void
    {

        $extAttr = $order->getExtensionAttributes();
        $orderExportDetails = $extAttr->getExportDetails();

        if (!$orderExportDetails) {
            $exportDetails = $this->orderExportDetailsFactory->create();
            $exportDetails->setOrderId((int) $order->getEntityId());
            $extAttr->setExportDetails($exportDetails);
        } else {
            $exportDetails = $orderExportDetails;
        }

        $success = $results['success']?? false;

        if ($success) {
            $time = new \DateTime();
            $time->setTimezone(new \DateTimeZone('UTC'));
            $exportDetails->setExportedAt($time);
        }

        if ($headerData->getShipDate()) {
            $exportDetails->setShipOn($headerData->getShipDate());
        }

        if ($headerData->getMerchantNotes()) {
            $exportDetails->setMerchantNotes($headerData->getMerchantNotes());
        }

        $this->orderExportDetailsRepository->save($exportDetails);
    }
}
