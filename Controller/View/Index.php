<?php

namespace ExequielLares\OrderExport\Controller\View;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
class Index implements ActionInterface, HttpGetActionInterface
{

    /**
     * @inheritDoc
     */
    public function execute()
    {
        die ('Hello World!');
        // TODO: Implement execute() method.
    }
}
