<?php
// ./modules/Hello.php
namespace Mediashare\Modules;

class Hello
{
    public $message;
    public function run() {
        if (empty($this->message)):
            $this->message = "Not message recorded :(";
        endif;
        echo $this->message;
        return $this;
    }
    
    public function setMessage(string $message) {
        $this->message = $message;
        return $this;
    }
}
