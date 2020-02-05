<?php

namespace Chauhan\Blog\Block;

use Chauhan\Blog\Model\ResourceModel\Blog\Collection;
use Chauhan\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class View extends Template
{
    private $collectionFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * return \Chauhan\Blog\Model\Item[]
     */
    public function getBlogDetail()
    {
        /** @var \Chauhan\Blog\Model\Post $model */
        return $this->_coreRegistry->registry('blog');
    }
}
