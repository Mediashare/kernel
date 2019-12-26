<?php
namespace Mediashare\Kernel;

use Mediashare\Kernel\Provider;

Class Kernel
{
    public $modules;
    public function run() {
        $this->modules = $this->getModules()->modules;
    }

    public function getModules() {
        $provider = new Provider();
        $provider->run();
        return $provider;
    }

    public function get(string $query) {
        foreach ($this->modules as $name => $module) {
            if ($name == $query) {
                return $module;
            }
        }
        return false;
    }
}
