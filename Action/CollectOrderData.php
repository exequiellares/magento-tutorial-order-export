<?php

namespace ExequielLares\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class CollectOrderData
 */
class CollectOrderData
{

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param int $orderId
     * @param \ExequielLares\OrderExport\Model\HeaderData $headerData
     * @return array
     */
    public function execute(int $orderId, \ExequielLares\OrderExport\Model\HeaderData $headerData)
    {
        $order = $this->orderRepository->get($orderId);

        $output = [];

        // TODO: Procesar datos y guardarlos en $output

        return $output;
    }

}
