<?php

namespace Chauhan\Blog\Block;

use Chauhan\Blog\Model\ResourceModel\Blog\Collection;
use Chauhan\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Blog extends Template
{
    private $collectionFactory;

    public function __construct(Template\Context $context, CollectionFactory $collectionFactory, array $data = [])
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * return \Chauhan\Blog\Model\Item[]
     */
    public function getBlogs()
    {
        return $this->collectionFactory->create()->getItemsByColumnValue('status', 1);
    }
}
