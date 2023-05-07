<?php

namespace ExequielLares\OrderExport\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderExportDetails extends AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_export', 'entity_id');
    }
}
