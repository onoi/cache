<?php

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */

error_reporting( E_ALL | E_STRICT );
date_default_timezone_set( 'UTC' );

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

if ( !is_readable( __DIR__ . '/../../../autoload.php' ) ) {
	die( 'The test suite requires the Composer autoloader to be present' );
}

$autoLoader = require __DIR__ . '/../../../autoload.php';
$autoLoader->addPsr4( 'Onoi\\Cache\\Tests\\', __DIR__ . '/phpunit/Unit' );
$autoLoader->addPsr4( 'Onoi\\Cache\\Tests\\Integration\\', __DIR__ . '/phpunit/Integration' );
