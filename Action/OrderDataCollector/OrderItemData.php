<?php

namespace ExequielLares\OrderExport\Action\OrderDataCollector;

use ExequielLares\OrderExport\Api\OrderDataCollectorInterface;
use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Action\GetOrderExportItems;
use Magento\Sales\Api\Data\OrderItemInterface;

class OrderItemData implements OrderDataCollectorInterface
{

    private GetOrderExportItems $getOrderExportItems;

    public function __construct(
        GetOrderExportItems $getOrderExportItems
    )
    {
        $this->getOrderExportItems = $getOrderExportItems;
    }

    /**
     * @inheritDoc
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $items = [];

        foreach ($this->getOrderExportItems->execute($order) as $orderItem) {
            $items[] = $this->transform($orderItem);
        }

        return [
            'items' => $items
        ];
    }

    private function transform(OrderItemInterface $orderItem): array
    {
        return [
            'sku' => $orderItem->getSku(),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal()
        ];
    }
}
