<?php
namespace Mediashare\Modules;

/**
 * Sync
 * Execute shell command scp & save prompt in $this->output[]
 */
class Sync
{
    public $username;
    public $host;
    public $directoy;
    public $destination;
    public $output = [];

    public function run() {
        $this->shell("scp -r ".$this->directory." ".$this->username."@".$this->host.":".$this->destination);
        return $this;
    }

    /**
     * Execute shell command & save prompt in $this->output[]
     *
     * @param string $command
     * @return this
     */
    public function shell(string $command) {
        $this->output[$command] = \shell_exec($command);
        return $this;
    }
}
