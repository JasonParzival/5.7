<?php

spl_autoload_register(function($class) {
    $fn = __DIR__ . '\\' . $class . '.php';
    
    if (file_exists($fn)) {
	    require_once $fn; 
    }
});