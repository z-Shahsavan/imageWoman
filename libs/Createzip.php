<?php

class Createzip {

    public static function Zip($source, $destination, $filesarray = NULL) {
        $files = glob('zip/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)){
                unlink($file); // delete file
            }
        }
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {//ok
            return false;
        }
        $source = str_replace('\\', '/', realpath($source));
        if (is_dir($source) === true) {
            if ($filesarray) {//array of file names in source folder
                foreach ($filesarray as $file) {
                    $f = $source . '/' . $file;
                    $f = str_replace('\\', '/', realpath($f));
                    if (is_dir($f) === true) {
                        $zip->addEmptyDir(str_replace($source . '/', '', $f . '/'));
                    } else if (is_file($f) === true) {
                        $zip->addFromString(str_replace($source . '/', '', $f), file_get_contents($f));
                    }
                }
            } else {
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                foreach ($files as $file) {
                    $file = str_replace('\\', '/', realpath($file));
                    if (is_dir($file) === true) {
                        $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                    } else if (is_file($file) === true) {
                        $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                    }
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }
        return $zip->close();
    }

}
