<?php

namespace ExequielLares\OrderExport\Action\OrderDataCollector;

use ExequielLares\OrderExport\Api\OrderDataCollectorInterface;
use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderAddressInterface;

/**
 *
 */
class OrderHeaderData implements OrderDataCollectorInterface
{

    /**
     * @var OrderAddressRepositoryInterface
     */
    private OrderAddressRepositoryInterface $orderAddressRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param OrderAddressRepositoryInterface $orderAddressRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderAddressRepositoryInterface $orderAddressRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->orderAddressRepository = $orderAddressRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [
            'id' => $order->getIncrementId(),
            'currency' => $order->getBaseCurrencyCode(),
            'discount' => $order->getBaseDiscountAmount(),
            'total' => $order->getBaseGrandTotal(),
        ];

        $shippingAddress = $this->getShippingAddress($order);
        if ($shippingAddress) {
            $output['shipping'] = [
                'name' => $shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname(),
                'address' => $shippingAddress->getStreet() ? implode(', ', $shippingAddress->getStreet()) : '',
                'city' => $shippingAddress->getCity(),
                'state' => $shippingAddress->getRegionCode(),
                'postcode' => $shippingAddress->getPostcode(),
                'country' => $shippingAddress->getCountryId(),
                'amount' => $order->getBaseShippingAmount(),
                'method' => $order->getShippingDescription()
            ];
        }


        return $output;
    }

    /**
     * @param OrderInterface $order
     * @return OrderAddressInterface|null
     */
    private function getShippingAddress(OrderInterface $order): ?OrderAddressInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('parent_id', $order->getEntityId())
            ->addFilter('address_type', 'shipping')
            ->create();

        $addresses = $this->orderAddressRepository->getList($searchCriteria);
        if (count($addresses->getItems()) === 0) {
            return null;
        }
        $items = $addresses->getItems();
        return reset($items);
    }
}
