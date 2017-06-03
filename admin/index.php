<?php
// Version
define('VERSION', '2.3.0.2');




// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit;
}

// Startup


//fwrite($file_test,"hello\n");
//fclose($file_test);
$test_fp  =   fopen('file_test.txt','w+');
require_once(DIR_SYSTEM . 'startup.php');

start('admin');
