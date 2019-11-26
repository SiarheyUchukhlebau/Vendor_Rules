<?php

namespace Vendor\Rules\Block\Adminhtml\Example;

class Rule extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'example_rule';
        $this->_headerText = __('Example Rules');
        $this->_addButtonLabel = __('Add New Rule');
        parent::_construct();
    }
}
