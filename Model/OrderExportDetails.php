<?php

namespace ExequielLares\OrderExport\Model;

use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use Magento\Framework\Model\AbstractModel;

class OrderExportDetails extends AbstractModel implements OrderExportDetailsInterface
{
    protected function _construct()
    {
        $this->_init(\ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @param int $orderId
     * @return OrderExportDetailsInterface
     */
    public function setOrderId(int $orderId): OrderExportDetailsInterface
    {
        $this->setData(self::ORDER_ID, $orderId);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShipOn(): ?\DateTime
    {
        $dateStr = $this->getData(self::SHIP_ON);
        try {
            $dateObj = ($dateStr) ? new \DateTime($dateStr) : null;
        } catch (\Exception $e) {
            $dateObj = null;
        }
        return $dateObj;
    }

    /**
     * @param \DateTime $shipOn
     * @return OrderExportDetailsInterface
     */
    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface
    {
        return $this->setData(self::SHIP_ON, $shipOn->format('Y-m-d'));
    }

    /**
     * @return string|null
     */
    public function getMerchantNotes(): ?string
    {
        return $this->getData(self::MERCHANT_NOTES);
    }

    /**
     * @param string $merchantNotes
     * @return OrderExportDetailsInterface
     */
    public function setMerchantNotes(string $merchantNotes): OrderExportDetailsInterface
    {
        $this->setData(self::MERCHANT_NOTES, $merchantNotes);
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExportedAt(): ?\DateTime
    {
        $dateStr = $this->getData(self::EXPORTED_AT);
        try {
            $dateObject = ($dateStr) ? new \DateTime($dateStr) : null;
        } catch (\Exception $e) {
            $dateObject = null;
        }
        return $dateObject;
    }

    /**
     * @param \DateTime $exportedAt
     * @return OrderExportDetailsInterface
     */
    public function setExportedAt(\DateTime $exportedAt): OrderExportDetailsInterface
    {
        $this->setData(self::EXPORTED_AT, $exportedAt->format('Y-m-d H:i:s'));
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBeenExported(): bool
    {
           return ($this->getExportedAt() !== null);
    }
}
