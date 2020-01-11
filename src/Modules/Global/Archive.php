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
        if (!extension_loaded('zip') || !file_exists($this->destination)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($this->destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
    
        $this->destination = str_replace('\\', '/', realpath($this->destination));
        $flag = basename($this->destination) . '/';
        //$zip->addEmptyDir(basename($this->destination) . '/');
    
        if (is_dir($this->destination) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->destination), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($this->destination . '/', '', $flag.$file . '/'));
                }
                else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($this->destination . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
        else if (is_file($this->destination) === true) {
            $zip->addFromString($flag.basename($this->destination), file_get_contents($this->destination));
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
