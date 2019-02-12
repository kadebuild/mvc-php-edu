<?php
ini_set('display_errors', 1);
require_once 'webapp/model.php';
require_once 'webapp/view.php';
require_once 'webapp/controller.php';
require_once 'webapp/router.php';
session_start();
Router::start();
?>