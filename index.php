<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();
dump($kernel);