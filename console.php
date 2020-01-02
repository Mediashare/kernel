<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();

$output = $kernel->get('Output');
$output->progressBar(1, 3, 'Init');
sleep(3);
$output->progressBar(2, 3, 'Git');
sleep(3);
$output->progressBar(3, 3, 'Push');
sleep(3);