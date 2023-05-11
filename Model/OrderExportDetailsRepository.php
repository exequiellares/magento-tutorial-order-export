<?php

namespace ExequielLares\OrderExport\Model;

use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResourceModel;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Model\AbstractModel;
use ExequielLares\OrderExport\Api\OrderExportDetailsRepositoryInterface;

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

    /**
     * @param OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
     * @param OrderExportDetailsResourceModel $orderExportDetailsResourceModel
     */
    public function __construct(
        OrderExportDetailsInterfaceFactory $orderExportDetailsFactory,
        OrderExportDetailsResourceModel $orderExportDetailsResourceModel
    )
    {

        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->orderExportDetailsResourceModel = $orderExportDetailsResourceModel;
    }

    /**
     * @param OrderExportDetailsInterface $orderExportDetails
     * @return OrderExportDetailsInterface
     * @throws CouldNotSaveException
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
     * @param int $orderExportDetailsId
     * @return OrderExportDetailsInterface
     * @throws NoSuchEntityException
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
     * @param OrderExportDetailsInterface $orderExportDetails
     * @return bool
     * @throws CouldNotDeleteException
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
     * @param int $orderExportDetailsId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $orderExportDetailsId): bool
    {
        return $this->delete($this->getById($orderExportDetailsId));
    }
}
