<?php

namespace Chauhan\Blog\Controller\Adminhtml\Index;

use Chauhan\Blog\Model\Config;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class Index extends Action
{
    private $config;
    public function __construct(Context $context, Config $config)
    {
        $this->config = $config;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->config->isEnabled()) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        }
        throw new NotFoundException(__('Module is disabled.'));
    }
}
