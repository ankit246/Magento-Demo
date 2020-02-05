<?php

namespace Chauhan\Blog\Controller\Adminhtml\Blog;

use Chauhan\Blog\Model\Blog;
use Chauhan\Blog\Model\BlogFactory;
use Chauhan\Blog\Model\Config;
use Magento\Backend\App\Action;

class Save extends Action
{
    private $blogFactory;
    private $config;
    public function __construct(Action\Context $context, BlogFactory $blogFactory, Config $config)
    {
        $this->blogFactory = $blogFactory;
        $this->config = $config;
        parent::__construct($context);
    }
    public function execute()
    {
        if ($this->config->isEnabled()) {
            $data = $this->getRequest()->getPostValue();
            if (isset($data['id'])) {
                $result = $this->blogFactory->create()
                    ->load($data['id']);
                $result->setTitle($data['title'])->setDescription($data['description'])->setUpdatedAt(date("Y-m-d h:i:sa"))->save();
                return $this->resultRedirectFactory->create()->setPath('blog/index/index');
            }
            $this->blogFactory->create()
                ->setData($data['general'])
                ->save();
            return $this->resultRedirectFactory->create()->setPath('blog/index/index');
        }
        // display error message
        $this->messageManager->addErrorMessage(__('Module is disabled.'));
        // go to grid
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
