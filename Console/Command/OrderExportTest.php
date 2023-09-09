<?php

namespace ExequielLares\OrderExport\Console\Command;


use Magento\Sales\Api\OrderRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExportTest extends Command
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderRepository = $orderRepository;
    }

    protected function configure()
    {
        $this->setName('order-export:test')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $order = $this->orderRepository->get(7);
        $extAttrs = $order->getExtensionAttributes();
        $exportDetails = $extAttrs->getExportDetails();
        if ($exportDetails) {
            $output->writeln(print_r($exportDetails->getData(), true));
        }
        return 0;
    }
}
