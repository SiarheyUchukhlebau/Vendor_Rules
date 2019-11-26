<?php

namespace Vendor\Rules\Controller\Adminhtml\Example\Rule;

class NewAction extends \Vendor\Rules\Controller\Adminhtml\Example\Rule
{
    /**
     * New action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
