<?php
namespace Mediashare\Modules;

/**
 * Create folder(s)
 */
class Mkdir
{
    public $path;
    public function run() {
        $folders = explode('/', $this->path);
        $path = '';
        foreach ($folders as $folder) {
            if (!empty($folder)):
                $path .= '/'.$folder;
                if (!\file_exists($path)):
                    \mkdir($path, 0777, true);
                endif;
            endif;
        }
        return $this;
    }
    public function setPath(string $path) {
        $this->path = $path;
        return $this;
    }
}
