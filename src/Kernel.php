<?php
namespace Mediashare\Kernel;

use Mediashare\Kernel\Provider;

Class Kernel
{
    public $modules = [];
    public function run() {
        $this->modules = $this->getModules()->modules;
    }

    public function getModules() {
        $provider = new Provider();
        $provider->run();
        return $provider;
    }

    public function get(string $kernel) {
        return $this->modules[$kernel];
    }
}
