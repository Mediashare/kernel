<?php
namespace Mediashare\Modules;

/**
 * Git
 * Php using git command line tool for 
 * ["add .", "commit -m '$this->message'", "push"]
 * @source http://slote.me/Kernel/git.html
 */
class Git
{
    public $message = "CodeReview";
    public $output = [];
    public function run() {
        $this->add();
        $this->commit();
        $this->push();
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

    /**
     * Add all file(s) edited in commit
     *
     * @return this
     */
    public function add() {
        $this->shell('git add .');
        return $this;
    }
    /**
     * Add message & stage all change
     *
     * @param string|null $message
     * @return this
     */
    public function commit(?string $message = null) {
        if (!$message):
            $message = $this->message;
        endif;
        $this->shell('git commit -a -m "'.$message.'"');
        return $this;
    }

    /**
     * Push commit to the remote server
     *
     * @return this
     */
    public function push() {
        $this->shell('git push');
        return $this;
    }
}
