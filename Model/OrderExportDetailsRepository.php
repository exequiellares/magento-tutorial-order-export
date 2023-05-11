<?php

namespace ExequielLares\OrderExport\Model;

use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;
use ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResourceModel;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Model\AbstractModel;
use ExequielLares\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterfaceFactory;
use ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails\Collection as OrderExportDetailsCollection;
use ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as OrderExportDetailsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Class OrderExportDetailsRepository
 */
class OrderExportDetailsRepository implements OrderExportDetailsRepositoryInterface
{

    /**
     * @var OrderExportDetailsInterfaceFactory
     */
    private OrderExportDetailsInterfaceFactory $orderExportDetailsFactory;
    /**
     * @var OrderExportDetailsResourceModel
     */
    private OrderExportDetailsResourceModel $orderExportDetailsResourceModel;
    private OrderExportDetailsSearchResultsInterfaceFactory $searchResultsFactory;
    private OrderExportDetailsCollectionFactory $orderExportDetailsCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @param OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
     * @param OrderExportDetailsResourceModel $orderExportDetailsResourceModel
     */
    public function __construct(
        OrderExportDetailsInterfaceFactory $orderExportDetailsFactory,
        OrderExportDetailsResourceModel $orderExportDetailsResourceModel,
        OrderExportDetailsSearchResultsInterfaceFactory $searchResultsFactory,
        OrderExportDetailsCollectionFactory $orderExportDetailsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {

        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->orderExportDetailsResourceModel = $orderExportDetailsResourceModel;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->orderExportDetailsCollectionFactory = $orderExportDetailsCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(OrderExportDetailsInterface $orderExportDetails): OrderExportDetailsInterface
    {
        if (!($orderExportDetails instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of OrderExportDetailsInterface must be an instance of %1', AbstractModel::class));
        }

        try {
            $this->orderExportDetailsResourceModel->save($orderExportDetails);
        } catch (AlreadyExistsException | \Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $orderExportDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $orderExportDetailsId): OrderExportDetailsInterface
    {
        $entity = $this->orderExportDetailsFactory->create();
        $this->orderExportDetailsResourceModel->load($entity, $orderExportDetailsId);
        if (!$entity->getId()) {
            throw new NoSuchEntityException(__('Order Export Details with id "%1" does not exist.', $orderExportDetailsId));
        }
        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OrderExportDetailsInterface $orderExportDetails): bool
    {
        if (!($orderExportDetails instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of OrderExportDetailsInterface must be an instance of %1', AbstractModel::class));
        }

        try {
            $this->orderExportDetailsResourceModel->delete($orderExportDetails);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $orderExportDetailsId): bool
    {
        return $this->delete($this->getById($orderExportDetailsId));
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): OrderExportDetailsSearchResultsInterface
    {
        /** @var OrderExportDetailsCollection $collection */
        $collection = $this->orderExportDetailsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var OrderExportDetailsSearchResultsInterface $result */
        $result = $this->searchResultsFactory->create();
        $result->setSearchCriteria($searchCriteria);
        $result->setItems($collection->getItems());
        $result->setTotalCount($collection->getSize());
        return $result;
    }
}
