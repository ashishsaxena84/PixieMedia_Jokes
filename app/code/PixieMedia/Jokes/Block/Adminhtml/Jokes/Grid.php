<?php
namespace PixieMedia\Jokes\Block\Adminhtml\Jokes;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \PixieMedia\Jokes\Model\jokesFactory
     */
    protected $_jokesFactory;

    /**
     * @var \PixieMedia\Jokes\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \PixieMedia\Jokes\Model\jokesFactory $jokesFactory
     * @param \PixieMedia\Jokes\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \PixieMedia\Jokes\Model\JokesFactory $JokesFactory,
        \PixieMedia\Jokes\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_jokesFactory = $JokesFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('joke_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_jokesFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        
				$this->addColumn(
					'id',
					[
						'header' => __('id'),
						'index' => 'id',
					]
				);
				
				$this->addColumn(
					'created_at',
					[
						'header' => __('Created At'),
						'index' => 'created_at',
						'type'      => 'datetime',
					]
				);

					
				$this->addColumn(
					'updated_at',
					[
						'header' => __('Updated At'),
						'index' => 'updated_at',
						'type'      => 'datetime',
					]
				);

					

						$this->addColumn(
							'enable',
							[
								'header' => __('Enable'),
								'index' => 'enable',
								'type' => 'options',
								'options' => \PixieMedia\Jokes\Block\Adminhtml\Jokes\Grid::getOptionArray7()
							]
						);

						


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'joke_id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('jokes/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('jokes/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('joke_id');
        //$this->getMassactionBlock()->setTemplate('PixieMedia_Jokes::jokes/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('jokes');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('jokes/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('jokes/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('jokes/*/index', ['_current' => true]);
    }

    /**
     * @param \PixieMedia\Jokes\Model\jokes|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'jokes/*/edit',
            ['joke_id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray7()
		{
            $data_array=array(); 
			$data_array[0]='no';
			$data_array[1]='yes';
            return($data_array);
		}
		static public function getValueArray7()
		{
            $data_array=array();
			foreach(\PixieMedia\Jokes\Block\Adminhtml\Jokes\Grid::getOptionArray7() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);
			}
            return($data_array);

		}
		

}