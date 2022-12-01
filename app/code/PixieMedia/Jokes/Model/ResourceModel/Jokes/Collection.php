<?php

namespace PixieMedia\Jokes\Model\ResourceModel\Jokes;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('PixieMedia\Jokes\Model\Jokes', 'PixieMedia\Jokes\Model\ResourceModel\Jokes');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>