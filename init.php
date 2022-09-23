<?php
spl_autoload_register('AutoloaderFunc');
function AutoloaderFunc($classname){
    $path = 'classes/';
    $extension = '.php';
    $filename = $path.$classname.$extension;
    if(!file_exists($filename)){
        return false;
    }
    include_once $filename;
}
?>