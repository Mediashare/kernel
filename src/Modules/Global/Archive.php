<?php
namespace Mediashare\Modules;

use ZipArchive;
use Mediashare\Modules\Mkdir;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Archive
{
    public $source;
    public $destination; 
    public function run() {
        if (!extension_loaded('zip') || !file_exists($this->source)) {
            return false;
        }

        // Create folder destination
        $mkdir = new Mkdir();
        $mkdir->setPath(dirname($this->destination));
        $mkdir->run();
        
        $zip = new ZipArchive();
        if (!$zip->open($this->destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
    
        $this->source = str_replace('\\', '/', realpath($this->source));
        $flag = basename($this->source) . '/';
        //$zip->addEmptyDir(basename($this->source) . '/');
        
        if (is_dir($this->source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->source), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($this->source . '/', '', $flag.$file . '/'));
                }
                else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($this->source . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
        else if (is_file($this->source) === true) {
            $zip->addFromString($flag.basename($this->source), file_get_contents($this->source));
        }
        $zip->close();
        return $this;
    }

    public function setSource(string $source) {
        $this->source = $source;
        return $this;
    }
    public function setDestination(string $destination) {
        $this->destination = $destination;
        return $this;
    }
}
