<?php

namespace ExequielLares\OrderExport\Api;

use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;

interface OrderExportDetailsRepositoryInterface
{

    /**
     * @param \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface $orderExportDetails
     * @return \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(OrderExportDetailsInterface $orderExportDetails): OrderExportDetailsInterface;

    /**
     * @param int $orderExportDetailsId
     * @return \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $orderExportDetailsId): OrderExportDetailsInterface;

    /**
     * @param \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface $orderExportDetails
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(OrderExportDetailsInterface $orderExportDetails): bool;

    /**
     * @param int $orderExportDetailsId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $orderExportDetailsId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \ExequielLares\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): OrderExportDetailsSearchResultsInterface;
}
