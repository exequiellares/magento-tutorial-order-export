<?php

namespace ExequielLares\OrderExport\Action\OrderDataCollector;

use ExequielLares\OrderExport\Api\OrderDataCollectorInterface;
use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;

class ExportHeaderData implements OrderDataCollectorInterface
{

    /**
     * @inheritDoc
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $shipDate = $headerData->getShipDate();
        return [
            'merchant_notes' => $headerData->getMerchantNotes(),
            'shipping' => [
                'ship_on' => ($shipDate !== null) ? $shipDate->format('d/m/Y') : ''
            ]
        ];
    }
}
