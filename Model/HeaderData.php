<?php

namespace ExequielLares\OrderExport\Model;

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

    public function getShipDate(): ?\DateTime
    {
        return $this->shipDate;
    }

    public function setShipDate(?\DateTime $shipDate): HeaderData
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    public function getMerchantNotes(): string
    {
        return $this->merchantNotes;
    }

    public function setMerchantNotes(string $merchantNotes): HeaderData
    {
        $this->merchantNotes = $merchantNotes;
        return $this;
    }

}
