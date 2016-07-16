<?php
require_once 'helpers/router.php';
require_once 'handlers.php';

define('ROOT_URL', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
    . $_SERVER['HTTP_HOST'] . '/');

define('TWI_REDIRECT_ACTION', 'twiredirect');
define('TWI_AUTH_ACTION', 'twiauth');
define('SAVED_ACTION', 'saved');

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

handle($action, 'index', [
    TWI_REDIRECT_ACTION => TWI_REDIRECT_ACTION,
    TWI_AUTH_ACTION     => TWI_AUTH_ACTION,
    SAVED_ACTION        => SAVED_ACTION
]);