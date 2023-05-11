<?php

namespace ExequielLares\OrderExport\Api;

use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface OrderExportDetailsRepositoryInterface
{

    /**
     * @param OrderExportDetailsInterface $orderExportDetails
     * @return OrderExportDetailsInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderExportDetailsInterface $orderExportDetails): OrderExportDetailsInterface;

    /**
     * @param int $orderExportDetailsId
     * @return OrderExportDetailsInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $orderExportDetailsId): OrderExportDetailsInterface;

    /**
     * @param OrderExportDetailsInterface $orderExportDetails
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OrderExportDetailsInterface $orderExportDetails): bool;

    /**
     * @param int $orderExportDetailsId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $orderExportDetailsId): bool;

//    public function getList();
}
