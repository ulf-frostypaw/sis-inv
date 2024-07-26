<?php
define('DB_HOST', '86.38.202.154');
define('DB_NAME', 'u309907878_equipo5');
define('DB_USER', 'u309907878_clima_polar_5');
define('DB_PASS', 'Equipo5_ClimaPolar.');
define('API_KEY', '');

// public data
define('APP_PUBLIC_URL', '*');
define('APP_VERSION', '1.0');

define('APP_MODE', 'dev'); // dev, prod


if (APP_MODE === 'dev') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

} elseif (APP_MODE === 'prod') {
    // hide all errors
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

/* 
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'clima_polar');
define('DB_USER', 'root');
define('DB_PASS', '');
define('API_KEY', '');

// public data
define('APP_PUBLIC_URL', '*');
define('APP_VERSION', '1.0');

define('APP_MODE', 'dev'); // dev, prod


if (APP_MODE === 'dev') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

} elseif (APP_MODE === 'prod') {
    // hide all errors
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
 */