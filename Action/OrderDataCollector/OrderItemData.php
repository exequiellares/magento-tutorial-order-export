<?php

namespace ExequielLares\OrderExport\Action\OrderDataCollector;

use ExequielLares\OrderExport\Api\OrderDataCollectorInterface;
use ExequielLares\OrderExport\Model\HeaderData;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Sales\Api\Data\OrderInterface;
use ExequielLares\OrderExport\Action\GetOrderExportItems;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 *
 */
class OrderItemData implements OrderDataCollectorInterface
{

    /**
     * @var GetOrderExportItems
     */
    private GetOrderExportItems $getOrderExportItems;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param GetOrderExportItems $getOrderExportItems
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        GetOrderExportItems $getOrderExportItems,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->getOrderExportItems = $getOrderExportItems;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $orderItems = $this->getOrderExportItems->execute($order);
        $skus = [];
        foreach ($orderItems as $orderItem) {
            $skus[] = $orderItem->getSku();
        }
        $productsBySku = $this->loadProducts($skus);
        $items = [];
        foreach ($orderItems as $orderItem) {
            $product = $productsBySku[$orderItem->getSku()] ?? null;
            $items[] = $this->transform($orderItem, $product);
        }

        return [
            'items' => $items
        ];
    }

    /**
     * @param array $skus
     * @return array
     */
    private function loadProducts(array $skus): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('sku', $skus, 'in')->create();
        $products = $this->productRepository->getList($searchCriteria)->getItems();
        $productsBySku = [];
        foreach($products as $product) {
            $productsBySku[$product->getSku()] = $product;
        }
        return $productsBySku;
    }

    /**
     * @param OrderItemInterface $orderItem
     * @param ProductInterface|null $product
     * @return array
     */
    private function transform(OrderItemInterface $orderItem, ?ProductInterface $product): array
    {
        return [
            'sku' => $this->getSku($orderItem, $product),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal()
        ];
    }

    /**
     * @param OrderItemInterface $orderItem
     * @param ProductInterface|null $product
     * @return string
     */
    private function getSku(OrderItemInterface $orderItem, ?ProductInterface $product): string
    {
        $sku = $orderItem->getSku();
        if ($product === null) {
            return $sku;
        }

        $skuOverride = $product->getCustomAttribute('sku_override');
        $skuOverrideVal = ($skuOverride !== null) ? $skuOverride->getValue() : null;

        if (!empty($skuOverrideVal)) {
            $sku = $skuOverrideVal;
        }
        return $sku;
    }
}
