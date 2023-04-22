<?php

namespace ExequielLares\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use ExequielLares\OrderExport\Model\HeaderData;
use ExequielLares\OrderExport\Api\OrderDataCollectorInterface;

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
     * @var OrderDataCollectorInterface[]
     */
    private array $collectors;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderDataCollectorInterface[] $collectors
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array $collectors = []
    )
    {
        $this->orderRepository = $orderRepository;
        $this->collectors = $collectors;
    }

    /**
     * @param int $orderId
     * @param \ExequielLares\OrderExport\Model\HeaderData $headerData
     * @return array
     */
    public function execute(int $orderId, HeaderData $headerData)
    {
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $this->orderRepository->get($orderId);
        $output = [];

        foreach($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }

}
