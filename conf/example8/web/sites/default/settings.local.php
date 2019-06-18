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
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
  ],
];

// Behind proxy.
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = [$_SERVER['REMOTE_ADDR']];
// HTTPS behind proxy.
if (
  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' &&
  !empty($settings['reverse_proxy']) &&
  in_array($_SERVER['REMOTE_ADDR'], $settings['reverse_proxy_addresses'])
) {
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['SERVER_PORT'] = 443;
}

$settings['trusted_host_patterns'][] = '^localhost$';
$settings['trusted_host_patterns'][] = '\.' . $_SERVER['BASE_DOMAIN'] . '$';

$settings['file_temporary_path'] = '/tmp';
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = '/var/www_files/private';

// @todo Add memcache.

$settings['hash_salt'] = 'dummy-value';

//$settings['config_exclude_modules'] = [
//  // 'devel',
//  // 'stage_file_proxy',
//  // 'config_exclude',
//  // 'kint',
//  // 'libraries_debug',
//  // 'log_stdout',
//];
//$config['config_split.config_split.local']['status'] = TRUE;

// Some settings to enable during development.
//assert_options(ASSERT_ACTIVE, TRUE);
//\Drupal\Component\Assertion\Handle::register();
//$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
//$config['system.performance']['css']['preprocess'] = FALSE;
//$config['system.performance']['js']['preprocess'] = FALSE;
//$settings['cache']['bins']['render'] = 'cache.backend.null';
//$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
//$settings['cache']['bins']['page'] = 'cache.backend.null';
//$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
//$settings['extension_discovery_scan_tests'] = TRUE;
//$settings['rebuild_access'] = TRUE;
//$settings['skip_permissions_hardening'] = TRUE;
