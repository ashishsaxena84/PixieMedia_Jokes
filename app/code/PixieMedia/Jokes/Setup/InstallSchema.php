<?php

namespace PixieMedia\Jokes\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0){

		$installer->run('CREATE TABLE `jokes` (
  `joke_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `icon_url` text NOT NULL,
  `url` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT 1,
PRIMARY KEY (`joke_id`))');
$installer->run('CREATE TABLE `joke_category` ( `id` int(11) NOT NULL AUTO_INCREMENT, `category_name` varchar(255) NOT NULL COMMENT \'Category ID\', PRIMARY KEY (`id`) )');
$installer->run('CREATE TABLE `joke_category_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT \'Category ID\',
  `joke_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT \'Joke ID\', PRIMARY KEY (`id`,`category_id`,`joke_id`))');


		

		}

        $installer->endSetup();

    }
}