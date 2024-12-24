<?php

define('ROOT', __DIR__);
define('FILE', __FILE__);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$folders = ['core', 'guards', 'models', 'controllers', 'views', 'routes', 'utils', 'interfaces'];

spl_autoload_register(function ($class) use ($folders) {
    // Convertir el namespace o nombre de clase en ruta de archivo
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    foreach ($folders as $folder) {
        $file = $baseDir . $folder . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';

        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});

require_once ROOT . '/routes/web.php';
