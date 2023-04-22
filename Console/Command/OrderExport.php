<?php

namespace ExequielLares\OrderExport\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use ExequielLares\OrderExport\Model\HeaderData;
use ExequielLares\OrderExport\Model\HeaderDataFactory;
use ExequielLares\OrderExport\Action\CollectOrderData;

/**
 *
 */
class OrderExport extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';
    /**
     * @var HeaderDataFactory
     */
    private HeaderDataFactory $headerDataFactory;
    /**
     * @var CollectOrderData
     */
    private CollectOrderData $collectOrderData;

    /**
     * @param HeaderDataFactory $headerDataFactory
     * @param CollectOrderData $collectOrderData
     * @param string|null $name
     */
    public function __construct(
        HeaderDataFactory $headerDataFactory,
        CollectOrderData $collectOrderData,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->collectOrderData = $collectOrderData;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-export:run')
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

        /** @var HeaderData $headerData */
        $headerData = $this->headerDataFactory->create();
        if ($shipDate) {
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if ($notes) {
            $headerData->setMerchantNotes($notes);
        }

        $orderData = $this->collectOrderData->execute($orderId, $headerData);

        $output->writeln(print_r($orderData, true));

        return 0;
    }
}
