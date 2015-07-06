<?php

require_once('pm/Loader.php');
pm_Loader::registerAutoload();
pm_Bootstrap::init();

pm_Context::init('panel-stats');

if (pm_Settings::get('useAuth') && @$_GET['authToken'] != pm_Settings::get('authToken')) {
    die('Invalid auth token supplied.');
}

$reporter = new Modules_PanelStats_Reporter();

$format = isset($_GET['format']) ? $_GET['format'] : 'xml';

if ('plain' == $format) {
    echo $reporter->getResultsPlain();
} else if ('json' == $format) {
    header("Content-Type: application/json");
    echo $reporter->getResultsJson();
} else {
    header("Content-Type: text/xml");
    echo $reporter->getResultsXml();
}

