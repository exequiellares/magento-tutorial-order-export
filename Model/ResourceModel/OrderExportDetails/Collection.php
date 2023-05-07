<?php

namespace ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\ExequielLares\OrderExport\Model\OrderExportDetails::class,
        \ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }
}
