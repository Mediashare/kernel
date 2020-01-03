<?php
namespace Mediashare\Kernel;

/**
 * Cluster
 * Create Modules Cluster for use automated action with function run().
 */
Class Cluster
{
    public $modules = []; // If null then enable all modules from $modulesDir
    public function getModules(): ?array {
        return $this->modules;
    }
    public function setModules(array $modules): self {
        $this->modules = $modules;
        return $this;
    }
    public function addModule(object $module): self {
        $this->modules[] = $module;
        return $this;
    }
    public function removeModule(string $module): self {
        foreach ($this->getModules() as $index => $object) {
            if ($module == $object):
                unset($this->modules[$index]);
            endif;
        }
        return $this;
    }

    public function run() {
        foreach ($this->modules as $module):
            if (method_exists($module, 'run')):
                $module->run();
            else:
                $message = "public function run() in Module [".$module->name."]. public function run() is needle for call automated action.";
                trigger_error($message, E_USER_NOTICE);
            endif;
        endforeach;
    }
}
