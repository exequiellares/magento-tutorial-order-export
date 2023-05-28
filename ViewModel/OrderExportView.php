<?php

namespace ExequielLares\OrderExport\ViewModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use ExequielLares\OrderExport\Api\Data\OrderExportDetailsInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use ExequielLares\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Page\Config as PageConfig;

/**
 * Class OrderExportView
 */
class OrderExportView implements ArgumentInterface
{

    /**
     * @var null|OrderInterface
     */
    private $order = null;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;
    /**
     * @var TimezoneInterface
     */
    private TimezoneInterface $timezone;
    /**
     * @var OrderExportDetailsRepositoryInterface
     */
    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var PageConfig
     */
    private PageConfig $pageConfig;

    /**
     * @param RequestInterface $request
     * @param OrderRepositoryInterface $orderRepository
     * @param UrlInterface $urlBuilder
     * @param TimezoneInterface $timezone
     * @param OrderExportDetailsRepositoryInterface $orderExportDetailsRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PageConfig $pageConfig
     */
    public function __construct(
        RequestInterface $request,
        OrderRepositoryInterface $orderRepository,
        UrlInterface $urlBuilder,
        TimezoneInterface $timezone,
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PageConfig $pageConfig
    )
    {

        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->urlBuilder = $urlBuilder;
        $this->timezone = $timezone;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->pageConfig = $pageConfig;
        $order = $this->getOrder();
        if ($order) {
            $this->pageConfig->getTitle()->set(__('Order # %1', $order->getIncrementId()));
        }
    }

    /**
     * @return string
     */
    public function getOrderViewUrl(): string
    {
        $order = $this->getOrder();
        if (!$order) {
            return '';
        }
        return $this->urlBuilder->getUrl(
            'sales/order/view',
            ['order_id' => $order->getEntityId()]
        );
    }

    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface
    {
        if (!$this->order) {
            $orderId = (int) $this->request->getParam('order_id');
            if (!$orderId) {
                return null;
            }
            try {
                $this->order = $this->orderRepository->get($orderId);
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }

        return $this->order;
    }

    /**
     * @return OrderExportDetailsInterface|null
     */
    public function getExportDetails(): ?OrderExportDetailsInterface
    {
        $order = $this->getOrder();
        if (!$order) {
            return null;
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('order_id', $order->getEntityId())
            ->create();
        $results = $this->orderExportDetailsRepository->getList($searchCriteria);

        if ($results->getTotalCount() > 0) {
            $items = $results->getItems();
            return reset($items);
        }
        return null;
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function formatDate(\DateTime $dateTime): string
    {
        return $this->timezone->formatDate($dateTime, \IntlDateFormatter::LONG);
    }
}
