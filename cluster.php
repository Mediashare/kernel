<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;
use Mediashare\Kernel\Cluster;

$kernel = new Kernel();
$kernel->run();

// Using Cluster
$cluster = new Cluster(); // Create Cluster
$cluster->setModules([
    clone $kernel->get('Hello')->setMessage("[RUN] Git push \n"), 
    clone $kernel->get('Git')->setMessage('CodeReview Cluster'), // Init message for commit
    clone $kernel->get('Hello')->setMessage("[END] Git push \n"),
]);
$cluster->run();
