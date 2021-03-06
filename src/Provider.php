<?php
namespace Mediashare\Kernel;

use Mediashare\ModulesProvider\Config;
use Mediashare\ModulesProvider\Modules;

class Provider
{
    public $modules = [];
    public function __construct() {
        $this->addModules($this->getModules("Global"));
        $this->addModules($this->getModules("SEO"));
        $this->addModules($this->getModules("Test"));
        $this->addModules($this->getModules("Console"));
        $this->addModules($this->getModules("Api"));
        return $this;
    }
    public function getModules(string $container) {
        $config = new Config();
        $config->setModulesDir(__DIR__.'/Modules/'.$container.'/');
        $config->setNamespace("Mediashare\\Modules\\");
        $modules = new Modules($config);
        $modules = $modules->getModules();
        foreach ($modules as $index => $module) {
            $module->container = $container;
            $name = str_replace($config->getNamespace(), '', get_class($module));
            $modules[$name] = $module;
            unset($modules[$index]);
        }
        return $modules;
    }
    public function addModules(array $modules): self {
        $this->modules = array_merge($this->modules, $modules);
        return $this;
    }
}
