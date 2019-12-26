<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();
dump($kernel);

$hello = $kernel->get('Hello');
$hello->echo("Test one module \n");

// Container with multiple modules from folder ./src/Modules/SEO/
$seo = $kernel->getContainer('SEO');
dump($seo);