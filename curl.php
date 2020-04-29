<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$request = $kernel->get('Curl');
// var_dump($request);die;

$response = $request->get('https://www.oxtorrent.co/');

var_dump($response);