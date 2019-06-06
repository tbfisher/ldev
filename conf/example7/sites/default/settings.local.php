<?php

/**
 * @file
 * Local override configuration file.
 */

$databases['default'] = [
  'default' => [
    'driver' => $_SERVER['DB_DRIVER'],
    'database' => $_SERVER['DB_NAME'],
    'username' => $_SERVER['DB_USER'],
    'password' => $_SERVER['DB_PASSWORD'],
    'host' => $_SERVER['DB_HOST'],
    'prefix' => '',
    // @see https://www.drupal.org/node/2754539
    'collation' => 'utf8_general_ci',
    // or
    //'charset' => 'utf8mb4',
    //'collation' => 'utf8mb4_general_ci',
  ],
];

// Behind proxy.
$conf['reverse_proxy'] = TRUE;
$conf['reverse_proxy_addresses'] = [$_SERVER['REMOTE_ADDR']];
// HTTPS behind proxy.
if (
  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
  //$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' &&
  !empty($conf['reverse_proxy']) &&
  in_array($_SERVER['REMOTE_ADDR'], $conf['reverse_proxy_addresses'])
) {
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['SERVER_PORT'] = 443;
}

// No poor-mans cron.
$conf['cron_safe_threshold'] = 0;

$conf['file_temporary_path'] = '/tmp';
$conf['file_public_path'] = 'sites/default/files';
$conf['file_private_path'] = '/var/www_files/private';

//$conf['redis_client_interface'] = 'PhpRedis';
//$conf['cache_backends'][] = 'sites/all/modules/contrib/redis/redis.autoload.inc';
//$conf['cache_default_class'] = 'Redis_Cache';
//$conf['cache_class_cache_form'] = 'DrupalDatabaseCache';
//$conf['lock_inc'] = 'sites/all/modules/contrib/redis/redis.lock.inc';
//$conf['redis_client_host'] = $_SERVER['CACHE_HOST'];
//$conf['redis_client_port'] = '6379';
//$conf['redis_client_base'] = '0';
//$conf['redis_client_password'] = '';

$settings['hash_salt'] = 'dummy-value';

// Some settings to enable during development.
// $conf['cache'] = FALSE;
// $conf['preprocess_css'] = FALSE;
// $conf['preprocess_js'] = FALSE;
// $conf['theme_debug'] = TRUE;

