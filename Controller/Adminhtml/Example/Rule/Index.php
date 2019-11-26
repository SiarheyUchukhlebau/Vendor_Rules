<?php

namespace Vendor\Rules\Controller\Adminhtml\Example\Rule;

class Index extends \Vendor\Rules\Controller\Adminhtml\Example\Rule
{
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Example Rules'), __('Example Rules'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Example Rules'));
        $this->_view->renderLayout('root');
    }
}
