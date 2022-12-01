<?php
namespace PixieMedia\Jokes\Model\ResourceModel;

class Jokes extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('jokes', 'joke_id');
    }
}
?>