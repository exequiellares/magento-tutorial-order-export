<?php

namespace ExequielLares\OrderExport\Api;

use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface OrderDataCollectorInterface
 */
interface OrderDataCollectorInterface
{
    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array;
}
