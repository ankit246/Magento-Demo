<?php

namespace Chauhan\Blog\Model\ResourceModel\Blog;

use Chauhan\Blog\Model\Blog;
use Chauhan\Blog\Model\ResourceModel\Blog as ResourceModelBlog;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    public function _construct()
    {
        $this->_init(Blog::class, ResourceModelBlog::class);
    }
}
