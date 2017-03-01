<?php

//namespace SBTechTest;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require('../autoload.php');

$request_uri = trim( $_SERVER['REQUEST_URI'], '/' );

use SBTechTest\API_Server;

$root_directory = realpath( __FILE__ );
$root_directory = str_replace( 'public/api.php', '', $root_directory );

$server = new API_Server( $request_uri, $root_directory );
$server->run();