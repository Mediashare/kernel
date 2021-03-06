<?php
namespace Mediashare\Kernel;

use Mediashare\Kernel\Provider;

Class Kernel
{
    public $modules;

    public function __construct() {
        $this->run();
        return $this;
    }

    public function run() {
        $this->modules = $this->getModules()->modules;
        return $this;
    }

    public function getModules() {
        $provider = new Provider();
        return $provider;
    }

    public function get(string $query) {
        foreach ($this->modules as $name => $module) {
            if ($name == $query) {
                return $module;
            }
        }
        return trigger_error("Module [".$query."] is not found in modules", E_USER_ERROR);
    }

    public function getContainer(string $container) {
        foreach ($this->modules as $module) {
            if ($module->container == $container) {
                $modules[$module->name] = $module;
            }
        }
        if (!empty($modules)):return $modules;
        else:
            return trigger_error("Container [".$container."] is not found in modules", E_USER_ERROR);
        endif;
    }
}
