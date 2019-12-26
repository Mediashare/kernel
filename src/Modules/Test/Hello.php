<?php
// ./modules/Hello.php
namespace Mediashare\Modules;

class Hello
{
    public $prefix;
    public function echo(?string $message) {
        if (empty($message)):
            $message = "Not message recorded :(";
        endif;
        $message = $this->prefix . $message;
        echo $message;
        return $message;
    }
}
