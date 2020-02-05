<?php

namespace Chauhan\Blog\Controller\Adminhtml\Blog;

use Chauhan\Blog\Model\Config;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    private $config;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Config $config
    ) {
        $this->config = $config;
        parent::__construct($context);
    }
    public function execute()
    {
        if ($this->config->isEnabled()) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        }
        // display error message
        $this->messageManager->addErrorMessage(__('Module is disabled.'));
        // go to grid
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
