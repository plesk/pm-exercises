<?php

class IndexController extends pm_Controller_Action
{
    public function init()
    {
        parent::init();

        // Init title for all actions
        $this->view->pageTitle = 'Example Module';

        // Init tabs for all actions
        $this->view->tabs = array(
            array(
                'title' => 'Form',
                'action' => 'form',
            ),
            array(
                'title' => 'Tools',
                'action' => 'tools',
            ),
            array(
                'title' => 'List',
                'action' => 'list',
            ),
        );
    }

    public function indexAction()
    {
        // Default action will be formAction
        $this->_forward('form');
    }

    public function formAction()
    {
        // Display simple text in view
        $this->view->test = 'This is index action for testing module.';

        // Init form here
        $form = new pm_Form_Simple();
        $form->addElement('text', 'exampleText', array(
            'label' => 'Example Text',
            'value' => pm_Settings::get('exampleText'),
            'required' => true,
            'validators' => array(
                array('NotEmpty', true),
            ),
        ));
        $form->addElement('password', 'examplePassword', array(
            'label' => 'Example Password',
            'value' => '',
            'description' => 'Password: ' . pm_Settings::get('examplePassword'),
            'validators' => array(
                array('StringLength', true, array(5, 255)),
            ),
        ));
        $form->addElement('textarea', 'exampleTextarea', array(
            'label' => 'Example TextArea',
            'value' => pm_Settings::get('exampleTextarea'),
            'class' => 'f-middle-size',
            'rows' => 4,
            'required' => true,
            'validators' => array(
                array('StringLength', true, array(0, 255)),
            ),
        ));
        $form->addElement('simpleText', 'exampleSimpleText', array(
            'label' => 'Example SimpleText',
            'escape' => false,
            'value' => '<a href="#">Link</a>',
        ));
        $form->addElement('select', 'exampleSelect', array(
            'label' => 'Example Select',
            'multiOptions' => array('opt-0' => 'Option 0', 'opt-1' => 'Option 1'),
            'value' => pm_Settings::get('exampleSelect'),
            'required' => true,
        ));
        $form->addElement('radio', 'exampleRadio', array(
            'label' => 'Example Radio',
            'multiOptions' => array('opt-0' => 'Option 0', 'opt-1' => 'Option 1'),
            'value' => pm_Settings::get('exampleRadio'),
            'required' => true,
        ));
        $form->addElement('checkbox', 'exampleCheckbox', array(
            'label' => 'Example Checkbox',
            'value' => pm_Settings::get('exampleCheckbox'),
        ));
        $form->addElement('hidden', 'exampleHidden', array(
            'value' => 'example',
        ));

        $form->addControlButtons(array(
            'cancelLink' => pm_Context::getModulesListUrl(),
        ));

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            // Form proccessing here
            pm_Settings::set('exampleText', $form->getValue('exampleText'));
            if ($form->getValue('examplePassword')) {
                pm_Settings::set('examplePassword', $form->getValue('examplePassword'));
            }
            pm_Settings::set('exampleTextarea', $form->getValue('exampleTextarea'));
            pm_Settings::set('exampleSelect', $form->getValue('exampleSelect'));
            pm_Settings::set('exampleRadio', $form->getValue('exampleRadio'));
            pm_Settings::set('exampleCheckbox', $form->getValue('exampleCheckbox'));

            $this->_status->addMessage('info', 'Data was successfully saved.');
            $this->_helper->json(array('redirect' => pm_Context::getBaseUrl()));
        }

        $this->view->form = $form;
    }

    public function toolsAction()
    {
        // Tools for pm_View_Helper_RenderTools
        $this->view->tools = array(
            array(
                'icon' => $this->view->skinUrl('/') . "img/icons/big/site-aps_32.gif",
                'title' => 'Example',
                'description' => 'Example module with UI samples',
                'link' => pm_Context::getBaseUrl(),
            ),
            array(
                'icon' => $this->view->skinUrl('/') . "img/icons/big/modules_32.gif",
                'title' => 'Modules',
                'description' => 'Modules installed in the Panel',
                'link' => pm_Context::getModulesListUrl(),
            ),
        );

        // Tools for pm_View_Helper_RenderSmallTools
        $this->view->smallTools = array(
            array(
                'title' => 'Example',
                'description' => 'Example module with UI samples',
                'class' => 'sb-app-info',
                'link' => pm_Context::getBaseUrl(),
            ),
            array(
                'title' => 'Modules',
                'description' => 'Modules installed in the Panel',
                'class' => 'sb-suspend',
                'link' => pm_Context::getModulesListUrl(),
            ),
        );
    }

    public function listAction()
    {
        $list = $this->_getListRandom();

        // List object for pm_View_Helper_RenderList
        $this->view->list = $list;
    }

    public function listDataAction()
    {
        $list = $this->_getListRandom();

        // Json data from pm_View_List_Simple
        $this->_helper->json($list->fetchData());
    }

    private function _getListRandom()
    {
        $data = array();
        $iconPath = pm_Context::getBaseUrl() . 'images/icon_16.gif';
        for ($i = 0; $i < 150; $i++) {
            $data[] = array(
                'column-1' => '<a href="#">' . (string)rand() . '</a>',
                'column-2' => '<img src="' . $iconPath . '" /> ' . (string)rand(),
            );
        }

        $list = new pm_View_List_Simple($this->view, $this->_request);
        $list->setData($data);
        $list->setColumns(array(
            'column-1' => array(
                'title' => 'Random with link',
                'noEscape' => true,
            ),
            'column-2' => array(
                'title' => 'Random with image',
                'noEscape' => true,
            ),
        ));
        // Take into account listDataAction corresponds to the URL /list-data/
        $list->setDataUrl(array('action' => 'list-data'));

        return $list;
    }
}
