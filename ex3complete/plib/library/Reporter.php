<?php

class Modules_PanelStats_Reporter
{

    private $_stats;

    public function __construct()
    {
        $request = '<server><get><stat/></get></server>';
        $this->_stats = pm_ApiRpc::getService()->call($request)->server->get->result->stat->objects;
    }

    public function getResultsXml()
    {
        $xml = new SimpleXMLElement('<stats/>');
        $xml->clients = $this->_stats->clients;
        $xml->domains = $this->_stats->domains;
        $xml->mail_boxes = $this->_stats->mail_boxes;
        $xml->databases = $this->_stats->databases;
        return (string)$xml->saveXml();
    }

    public function getResultsPlain()
    {
        return
            "clients: {$this->_stats->clients}\n" .
            "domains: {$this->_stats->domains}\n" .
            "mail_boxes: {$this->_stats->mail_boxes}\n" .
            "databases: {$this->_stats->databases}";
    }

    public function getResultsJson()
    {
        $result = array(
            'clients' => (string)$this->_stats->clients,
            'domains' => (string)$this->_stats->domains,
            'mail_boxes' => (string)$this->_stats->mail_boxes,
            'databases' => (string)$this->_stats->databases,
        );
        echo json_encode($result);
    }

}
