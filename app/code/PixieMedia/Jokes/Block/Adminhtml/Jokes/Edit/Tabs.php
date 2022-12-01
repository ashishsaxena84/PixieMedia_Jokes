<?php
namespace PixieMedia\Jokes\Block\Adminhtml\Jokes\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('jokes_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Jokes Information'));
    }
}