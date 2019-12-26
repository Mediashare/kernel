<?php
namespace Mediashare\Kernel;

use Mediashare\ModulesProvider\Config;
use Mediashare\ModulesProvider\Modules;

class Provider
{
    public $modules = [];
    public function run() {
        $this->addModules($this->getModules("SEO"));
        $this->addModules($this->getModules("Test"));
        return $this;
    }
    public function getModules(string $category) {
        $config = new Config();
        $config->setModulesDir(__DIR__.'/Modules/'.$category.'/');
        $config->setNamespace("Mediashare\\Modules\\");
        $modules = new Modules($config);
        $modules = $modules->getModules();
        foreach ($modules as $index => $module) {
            $module->category = $category;
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
