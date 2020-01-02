<?php
namespace Mediashare\Modules;

/**
 * Arguments
 * @source http://slote.me/Kernel/arguments.html#installation
 */
class Arguments
{
    public $argv = [];
    public $arguments = [];
    public function run() {
        $this->setArguments();
        return $this;
    }

    public function get(string $option) {
        if (isset($this->arguments[$option])):
            return $this->arguments[$option];
        endif;
        return false;
    }

    public function getArguments() {
        return $this->arguments;
    }

    private function setArguments() {
        $isOption = false;
        foreach ($this->argv as $index => $value) {
            $isOption = $this->isOption($value);
            if ($isOption):
                $this->arguments[$value] = [];
                $option = $value;
            elseif (!empty($option)):
                $this->arguments[$option][] = $value;
            endif;
        }
    }

    private function isOption(string $value) {
        $isOption = false;
        if (\strpos(\substr($value, 0, 2), '--') !== false):
            $isOption = true;
        elseif (\strpos(\substr($value, 0, 1), '-') !== false):
            $isOption = true;
        endif;
        return $isOption;
    }
}
