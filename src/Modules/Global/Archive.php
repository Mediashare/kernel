<?php
namespace Mediashare\Modules;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Archive
{
    public $source;
    public $destination; 
    public function run() {
        if (!extension_loaded('zip') || !file_exists($this->directory)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($this->destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
    
        $this->directory = str_replace('\\', '/', realpath($this->directory));
        $flag = basename($this->directory) . '/';
        //$zip->addEmptyDir(basename($this->directory) . '/');
    
        if (is_dir($this->directory) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($this->directory . '/', '', $flag.$file . '/'));
                }
                else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($this->directory . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
        else if (is_file($this->directory) === true) {
            $zip->addFromString($flag.basename($this->directory), file_get_contents($this->directory));
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
