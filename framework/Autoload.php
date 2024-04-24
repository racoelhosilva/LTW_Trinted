<?php
/**
 * @brief Loads custom class files from specific directories
 * 
 * @param string $class_name name of the class to be loaded
 */
function autoload($class_name) {
    // Base directories to look for class declarations
    $base_dirs = [
        __DIR__ . '/../framework/',
        __DIR__ . '/../middlewares/',
        __DIR__ . '/../db/classes/',
    ];

    foreach ($base_dirs as $base_dir) {
        $file_path = $base_dir . $class_name . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
            return;
        }
        $file_path = $base_dir . $class_name . '.class.php';
        if (file_exists($file_path)) {
            require_once $file_path;
            return;
        }
    }
}

spl_autoload_register('autoload');