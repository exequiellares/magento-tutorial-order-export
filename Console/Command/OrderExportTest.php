<?php

namespace ExequielLares\OrderExport\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use ExequielLares\OrderExport\Model\HeaderData;
use ExequielLares\OrderExport\Model\HeaderDataFactory;
use ExequielLares\OrderExport\Action\ExportOrder;

/**
 *
 */
class OrderExportTest extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';

    /**
     * @var HeaderDataFactory
     */
    private HeaderDataFactory $headerDataFactory;

    /**
     * @var ExportOrder
     */
    private ExportOrder $exportOrder;
    private \ExequielLares\OrderExport\Model\OrderExportDetailsFactory $orderExportDetailsFactory;
    private \ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails $orderExportDetailsResource;
    private \ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory $orderExportDetailsCollectionFactory;

    /**
     * @param HeaderDataFactory $headerDataFactory
     * @param ExportOrder $exportOrder
     * @param string|null $name
     */
    public function __construct(
        HeaderDataFactory $headerDataFactory,
        ExportOrder $exportOrder,
        \ExequielLares\OrderExport\Model\OrderExportDetailsFactory $orderExportDetailsFactory,
        \ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails $orderExportDetailsResource,
        \ExequielLares\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory $orderExportDetailsCollectionFactory,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->exportOrder = $exportOrder;
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->orderExportDetailsResource = $orderExportDetailsResource;
        $this->orderExportDetailsCollectionFactory = $orderExportDetailsCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-export:test')
            ->setDescription('Export order to ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                'Order Id'
            )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Shipping date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_MERCHANT_NOTES,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderId = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTES);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);

//        $model = $this->orderExportDetailsFactory->create();
//
//        $model->setOrderId($orderId)
//            ->setMerchantNotes($notes)
//            ->setShipOn(new \DateTime())
//            ->setExportedAt(new \DateTime());
//
//        $output->writeln(print_r($model->getData(), true));
//
//        $this->orderExportDetailsResource->save($model);
//        $this->orderExportDetailsResource->delete($model);
//
//        $modelToUpdate = $this->orderExportDetailsFactory->create();
//        $this->orderExportDetailsResource->load($modelToUpdate, 1);
//
//        $modelToUpdate->setMerchantNotes('Esto es un modelo editado');
//        $output->writeln(print_r($modelToUpdate->getData(), true));
//        $this->orderExportDetailsResource->save($modelToUpdate);

        $collection = $this->orderExportDetailsCollectionFactory->create()
            ->addFieldToSelect(['order_id', 'merchant_notes'])
            ->addFieldToFilter('merchant_notes', ['like' => '%nota%']);


        foreach ($collection as $item) {
            $output->writeln(print_r($item->getData(), true));
        }

        return 0;
    }
}
