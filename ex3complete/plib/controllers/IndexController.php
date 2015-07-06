<?php

class IndexController extends pm_Controller_Action
{
    public function indexAction()
    {
        // TODO: allow access for admin only

        $this->view->pageTitle = 'Panel Statistics Settings';

        $form = new Modules_PanelStats_Form_Settings();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $form->process();
            $this->_status->addMessage('info', 'Settings were saved.');
            $this->_helper->json(array('redirect' => pm_Context::getModulesListUrl()));
        }

        $this->view->form = $form;
    }
}
