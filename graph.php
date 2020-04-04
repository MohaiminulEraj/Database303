<?php
require_once  "./vendor/autoload.php";

require_once "Datareport.php";

$report = new Datareport;

$report->run()->render();
