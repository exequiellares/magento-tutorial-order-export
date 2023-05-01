<?php

namespace ExequielLares\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
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
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function execute(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [];
        foreach($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }

}
