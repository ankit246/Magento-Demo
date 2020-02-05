<?php

namespace Chauhan\Blog\Model;

use Chauhan\Blog\Model\ResourceModel\Blog as ResourceModelBlog;
use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModelBlog::class);
    }
}
