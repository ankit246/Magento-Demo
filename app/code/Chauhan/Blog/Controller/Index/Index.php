<?php

namespace Chauhan\Blog\Controller\Index;

use Chauhan\Blog\Model\Config;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
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
