<?php

namespace ExequielLares\OrderExport\Controller\View;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Sales\Controller\AbstractController\OrderViewAuthorizationInterface;
use ExequielLares\OrderExport\Model\Config;

class Index implements ActionInterface, HttpGetActionInterface
{

    private PageFactory $pageFactory;
    private RequestInterface $request;
    private OrderRepositoryInterface $orderRepository;
    private ForwardFactory $forwardFactory;
    private OrderViewAuthorizationInterface $orderAuthorization;
    private Config $config;

    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        OrderRepositoryInterface $orderRepository,
        ForwardFactory $forwardFactory,
        OrderViewAuthorizationInterface $orderAuthorization,
        Config $config
    )
    {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->forwardFactory = $forwardFactory;
        $this->orderAuthorization = $orderAuthorization;
        $this->config = $config;
    }
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $forward = $this->forwardFactory->create();

        if (!$this->config->isEnabled()) {
            return $forward->forward('noroute');
        }

        $orderId = (int) $this->request->getParam('order_id');
        if (!$orderId) {
            return $forward->forward('noroute');
        }

        try {
            $order = $this->orderRepository->get($orderId);
        } catch (\Exception $e) {
            return $forward->forward('noroute');
        }

        if (!$this->orderAuthorization->canView($order)) {
            return $forward->forward('noroute');
        }

        /** @var Page $pageResult */
        $pageResult = $this->pageFactory->create();
        return $pageResult;
    }
}
