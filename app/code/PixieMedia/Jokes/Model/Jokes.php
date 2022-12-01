<?php
namespace PixieMedia\Jokes\Model;

class Jokes extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('PixieMedia\Jokes\Model\ResourceModel\Jokes');
    }
}
?>