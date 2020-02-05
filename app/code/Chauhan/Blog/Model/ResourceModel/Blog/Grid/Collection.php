<?php

namespace Chauhan\Blog\Model\ResourceModel\Blog\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface;

class Collection extends SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategyInterface,
        ManagerInterface $managerInterface,
        $mainTable = "blog",
        $resourceModel = "Chauhan\Blog\Model\ResourceModel\Blog"
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategyInterface, $managerInterface, $mainTable, $resourceModel);
    }
}
