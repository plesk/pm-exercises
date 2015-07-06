<?php

class Modules_PanelStats_Form_Settings extends pm_Form_Simple
{

    public function init()
    {
        $this->addElement('description', 'description', array(
            'description' => 'You can protect statistics information or make it public available.',
        ));

        $useAuth = (bool)pm_Settings::get('useAuth');

        $this->addElement('checkbox', 'useAuth', array(
            'label' => 'Protect access using auth token',
            'value' => $useAuth,
        ));

        $authToken = pm_Settings::get('authToken');

        $this->addElement('text', 'authToken', array(
            'label' => 'Auth token',
            'value' => $authToken,
        ));

        $authToken = $useAuth ? $authToken : '';

        $baseUrl = pm_Context::getBaseUrl() . "public/?authToken=$authToken";

        $this->addElement('simpleText', 'link_xml', array(
            'label' => 'Statistics in XML format',
            'escape' => false,
            'value' => "<a href='$baseUrl&format=xml' target='_blank'>Link</a>",
        ));

        $this->addElement('simpleText', 'link_json', array(
            'label' => 'Statistics in JSON format',
            'escape' => false,
            'value' => "<a href='$baseUrl&format=json' target='_blank'>Link</a>",
        ));

        $this->addElement('simpleText', 'link_plain', array(
            'label' => 'Statistics in plain text format',
            'escape' => false,
            'value' => "<a href='$baseUrl&format=plain' target='_blank'>Link</a>",
        ));

        $this->addControlButtons(array(
            'cancelHidden' => true,
        ));
    }

    public function process()
    {
        $values = $this->getValues();
        pm_Settings::set('useAuth', (bool)$values['useAuth']);
        pm_Settings::set('authToken', $values['authToken']);
    }

}
