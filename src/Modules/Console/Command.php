<?php
namespace Mediashare\Modules;

/**
 * Command
 * Execute shell command & save prompt in $this->commands[]
 */
class Command
{
    public $commands = [];

    /**
     * Execute shell command & save prompt in $this->commands[]
     *
     * @param string $command
     * @return this
     */
    public function run(string $command) {
        $this->commands[$command] = \shell_exec($command);
        return $this;
    }
}
