<?php
namespace Mediashare\Kernel;

use Mediashare\Kernel\Provider;

Class Kernel
{
    public $modules = [];
    public function run() {
        $this->modules = $this->getModulesCluster()->modules;
    }

    public function getModulesCluster() {
        $provider = new Provider();
        $provider->run();
        return $provider;
    }
}
