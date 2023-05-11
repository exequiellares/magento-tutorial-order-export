<?php

namespace ExequielLares\OrderExport\Api\Data;

interface OrderExportDetailsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * @return \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}
