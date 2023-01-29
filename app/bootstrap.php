<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/x-www-form-urlencoded');

include_once(__DIR__.'/config.php');
include_once(__DIR__.'/crest/crest.php');
include_once(__DIR__.'/classes/Helper.php');
include_once(__DIR__.'/classes/Deal.php');
include_once(__DIR__.'/classes/Task.php');
include_once(__DIR__.'/classes/Contact.php');
include_once(__DIR__.'/classes/User.php');
