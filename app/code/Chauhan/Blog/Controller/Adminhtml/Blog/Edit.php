<?php

namespace Chauhan\Blog\Controller\Adminhtml\Blog;

use Chauhan\Blog\Model\Blog;
use Chauhan\Blog\Model\Config;
use Magento\Backend\App\Action;

class Edit extends Action
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
        \Magento\Backend\App\Action\Context $context,
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
    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
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
            $this->initPage($resultPage)->addBreadcrumb(
                $id ? __('Edit Block') : __('New Block'),
                $id ? __('Edit Block') : __('New Block')
            );
            $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));
            $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Blog'));
            return $resultPage;
        }
        // display error message
        $this->messageManager->addErrorMessage(__('Module is disabled.'));
        // go to grid
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
