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
        if (!extension_loaded('zip') || !file_exists($directory)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
    
        $directory = str_replace('\\', '/', realpath($directory));
        $flag = basename($directory) . '/';
        //$zip->addEmptyDir(basename($directory) . '/');
    
        if (is_dir($directory) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($directory . '/', '', $flag.$file . '/'));
                }
                else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($directory . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
        else if (is_file($directory) === true) {
            $zip->addFromString($flag.basename($directory), file_get_contents($directory));
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
