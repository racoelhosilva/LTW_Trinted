<?php
function autoload($class_name) {
    $base_dirs = [
      __DIR__ . '/../pages/',
      __DIR__ . '/../utils/',
      __DIR__ . '/../template/',
    ];

    foreach ($base_dirs as $base_dir) {
        $file_path = $base_dir . $class_name . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
            return;
        }
    }
}

spl_autoload_register('autoload');