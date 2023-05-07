<?php

namespace ExequielLares\OrderExport\Api\Data;

interface OrderExportDetailsInterface
{

    const ENTITY_ID = 'entity_id';
    const ORDER_ID = 'order_id';
    const SHIP_ON = 'ship_on';
    const MERCHANT_NOTES = 'merchant_notes';
    const EXPORTED_AT = 'exported_at';

    /**
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * @param int $orderId
     * @return OrderExportDetailsInterface
     */
    public function setOrderId(int $orderId): OrderExportDetailsInterface;

    /**
     * @return \DateTime|null
     */
    public function getShipOn(): ?\DateTime;

    /**
     * @param \DateTime $shipOn
     * @return OrderExportDetailsInterface
     */
    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface;

    /**
     * @return string|null
     */
    public function getMerchantNotes(): ?string;

    /**
     * @param string $merchantNotes
     * @return OrderExportDetailsInterface
     */
    public function setMerchantNotes(string $merchantNotes): OrderExportDetailsInterface;

    /**
     * @return \DateTime|null
     */
    public function getExportedAt(): ?\DateTime;

    /**
     * @param \DateTime $exportedAt
     * @return OrderExportDetailsInterface
     */
    public function setExportedAt(\DateTime $exportedAt): OrderExportDetailsInterface;

    /**
     * @return bool
     */
    public function hasBeenExported(): bool;
}
