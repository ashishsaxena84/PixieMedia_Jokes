<?php

namespace PixieMedia\Jokes\Controller\Adminhtml\jokes;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPagee;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('PixieMedia_Jokes::jokes');
        $resultPage->addBreadcrumb(__('PixieMedia'), __('PixieMedia'));
        $resultPage->addBreadcrumb(__('Manage item'), __('Manage Jokes'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Jokes'));

        return $resultPage;
    }
}
?>