<?php
// ./modules/Hello.php
namespace Mediashare\Modules;

class Hello
{
    public $prefix;
    public function run() {
        $this->echo();
    }
    public function echo(?string $message = null) {
        if (empty($message)):
            $message = "Not message recorded :(";
        endif;
        $message = $this->prefix . $message;
        echo $message;
        return $message;
    }
    
    public function setMessage(string $message) {
        $this->message = $message;
        return $this;
    }
}
