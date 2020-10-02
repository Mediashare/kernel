<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
// dump($kernel);

$request = $kernel->get('Curl');
$response = $request->get('https://www2.yggtorrent.si/torrent/filmvid%C3%A9o/film/667716-de+toutes+nos+forces+2013+french+brrip+xvid+ac3-notag');
var_dump($response);die;

$hello = $kernel->get('Hello');
$hello->echo("Test one module \n");

// Container with multiple modules from folder ./src/Modules/SEO/
$seo = $kernel->getContainer('SEO');
dump($seo);