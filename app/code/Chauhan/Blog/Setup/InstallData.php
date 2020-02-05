<?php

namespace Chauhan\Blog\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $setup->getConnection()->insert(
            $setup->getTable('blog'),
            ['title' => 'Lorem Ipsum 1', 'description' => 'Lorem Ipsum dolar input']
        );
        $setup->getConnection()->insert(
            $setup->getTable('blog'),
            ['title' => 'Lorem Ipsum 2', 'description' => 'Lorem Ipsum dolar input']
        );
        $setup->endSetup();
    }
}
