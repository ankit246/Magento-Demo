<?php

namespace Chauhan\Blog\Controller\Page;

use Chauhan\Blog\Model\Blog;
use Chauhan\Blog\Model\Config;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class View extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $config;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Config $config
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->config = $config;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {

        $resultPage->setActiveMenu('Chauhan_Blog::blog')
            ->addBreadcrumb(__('CMS'), __('CMS'))
            ->addBreadcrumb(__('Static Blogs'), __('Static Blogs'));
        return $resultPage;
    }
    public function execute()
    {
        if ($this->config->isEnabled()) {
            // 1. Get ID and create model
            $id = $this->getRequest()->getParam('id');
            $model = $this->_objectManager->create(Blog::class);

            // 2. Initial checking
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This blog no longer exists.'));
                    /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $this->_coreRegistry->register('blog', $model);

            // 5. Build edit form
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();

            return $resultPage;
        }
        throw new NotFoundException(__('Module is disabled.'));
    }
}
