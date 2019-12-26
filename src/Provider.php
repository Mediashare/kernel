<?php
namespace Mediashare\Kernel;

use Mediashare\ModulesProvider\Config;
use Mediashare\ModulesProvider\Modules;

class Provider
{
    public $modules = [];
    public function run() {
        $this->modules["SEO"] = $this->getModules("SEO");
        $this->modules["Test"] = $this->getModules("Test");
        return $this;
    }
    public function getModules(string $folder) {
        $config = new Config();
        $config->setModulesDir(__DIR__.'/Modules/'.$folder.'/');
        $config->setNamespace("Mediashare\\Modules\\");
        $modules = new Modules($config);
        $modules = $modules->getModules();
        return $modules;

    }
}
