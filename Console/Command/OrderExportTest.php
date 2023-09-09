<?php

namespace ExequielLares\OrderExport\Console\Command;


use Magento\Sales\Api\OrderRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class OrderExportTest extends Command
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    protected function configure()
    {
        $this->setName('order-export:test')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Test - After Get
//        $order = $this->orderRepository->get(7);
//        $extAttrs = $order->getExtensionAttributes();
//        $exportDetails = $extAttrs->getExportDetails();
//        if ($exportDetails) {
//            $output->writeln(print_r($exportDetails->getData(), true));
//        }

        // Test - After Get List
        $this->searchCriteriaBuilder->setPageSize(5);
        $result = $this->orderRepository->getList($this->searchCriteriaBuilder->create());
        $orders = $result->getItems();
        foreach ($orders as $order) {
            $extAttrs = $order->getExtensionAttributes();
            $exportDetails = $extAttrs->getExportDetails();
            $output->writeln($order->getIncrementId());
            if ($exportDetails) {
                $output->writeln(print_r($exportDetails->getData(), true));
            }
        }
        return 0;
    }
}
