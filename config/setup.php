<?php

define('ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
define('CONTROLLER', realpath(ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controller'));
define('TEMPLATES', realpath(ROOT . DIRECTORY_SEPARATOR . 'templates'));
define('MYSQL_FILE_PATH', realpath(ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'mysql.ini'));

require implode(DIRECTORY_SEPARATOR, [
    ROOT,
    'vendor',
    'autoload.php'
]);
