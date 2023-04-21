<?php

namespace ExequielLares\OrderExport\Model;

/**
 *
 */
class HeaderData
{

    /**
     * @var null|\DateTime
     */
    private $shipDate;

    /**
     * @var string
     */
    private $merchantNotes;

    /**
     * @return \DateTime|null
     */
    public function getShipDate(): ?\DateTime
    {
        return $this->shipDate;
    }

    /**
     * @param \DateTime|null $shipDate
     * @return $this
     */
    public function setShipDate(?\DateTime $shipDate): HeaderData
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantNotes(): string
    {
        return $this->merchantNotes;
    }

    /**
     * @param string $merchantNotes
     * @return $this
     */
    public function setMerchantNotes(string $merchantNotes): HeaderData
    {
        $this->merchantNotes = $merchantNotes;
        return $this;
    }

}
