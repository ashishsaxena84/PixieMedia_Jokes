<?php

namespace PixieMedia\Jokes\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

    protected $_jokesFactory; 


    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \PixieMedia\Jokes\Model\JokesFactory $jokesFactory,
        array $data = []
     ) {
        $this->_jokesFactory = $jokesFactory;
        parent::__construct($context, $data);
        //get collection of data 
        $collection = $this->_jokesFactory->create()->getCollection();
        $this->setCollection($collection);
        $this->pageConfig->getTitle()->set(__('Jokes'));
    }


    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            // create pager block for collection 
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'pixiemedia.jokes.record.pager'
            )->setCollection(
                $this->getCollection() // assign collection to pager
            );
            $this->setChild('pager', $pager);// set pager block in layout
        }
        return $this;
    }

    /**
     * @return string
     */
    // method for get pager html
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }   

}