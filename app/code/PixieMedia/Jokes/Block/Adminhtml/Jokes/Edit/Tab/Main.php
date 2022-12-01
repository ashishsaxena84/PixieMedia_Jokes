<?php

namespace PixieMedia\Jokes\Block\Adminhtml\Jokes\Edit\Tab;

/**
 * Jokes edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \PixieMedia\Jokes\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \PixieMedia\Jokes\Model\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \PixieMedia\Jokes\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('jokes');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('joke_id', 'hidden', ['name' => 'joke_id']);
        }

		
        $fieldset->addField(
            'id',
            'text',
            [
                'name' => 'id',
                'label' => __('id'),
                'title' => __('id'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$wysiwygConfig = $objectManager->create('Magento\Cms\Model\Wysiwyg\Config');
        $widgetFilters = ['is_email_compatible' => 1];
        $wysiwygConfig = $wysiwygConfig->getConfig(['widget_filters' => $widgetFilters]);

        $fieldset->addField(
            'value',
            'editor',
            [
                'name' => 'value',
                'label' => __('Value'),
                'title' => __('Value'),
                'config' => $wysiwygConfig,
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );


						

        $fieldset->addField(
            'icon_url',
            'image',
            [
                'name' => 'icon_url',
                'label' => __('Icon Url'),
                'title' => __('Icon Url'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

						
        $fieldset->addField(
            'url',
            'textarea',
            [
                'name' => 'url',
                'label' => __('Url'),
                'title' => __('Url'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					

        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::MEDIUM
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::MEDIUM
        );

        $fieldset->addField(
            'created_at',
            'date',
            [
                'name' => 'created_at',
                'label' => __('Created At'),
                'title' => __('Created At'),
                    'date_format' => $dateFormat,
                    //'time_format' => $timeFormat,
				
                'disabled' => $isElementDisabled
            ]
        );


						

        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::MEDIUM
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::MEDIUM
        );

        $fieldset->addField(
            'updated_at',
            'date',
            [
                'name' => 'updated_at',
                'label' => __('Updated At'),
                'title' => __('Updated At'),
                    'date_format' => $dateFormat,
                    //'time_format' => $timeFormat,
				
                'disabled' => $isElementDisabled
            ]
        );


						

        $fieldset->addField(
            'enable',
            'select',
            [
                'label' => __('Enable'),
                'title' => __('Enable'),
                'name' => 'enable',
				
                'options' => \PixieMedia\Jokes\Block\Adminhtml\Jokes\Grid::getOptionArray7(),
                'disabled' => $isElementDisabled
            ]
        );

						

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getTargetOptionArray(){
    	return array(
    				'_self' => "Self",
					'_blank' => "New Page",
    				);
    }
}
