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

if ( is_readable( $path = __DIR__ . '/../vendor/autoload.php' ) ) {
	print( "\nUsing the local vendor autoloader ...\n\n" );
} elseif ( is_readable( $path = __DIR__ . '/../../../vendor/autoload.php' ) ) {
	print( "\nUsing the MediaWiki vendor autoloader ...\n\n" );
} else {
	die( 'The test suite requires a Composer based deployement.' );
}

$autoLoader = require $path;
$autoLoader->addPsr4( 'Onoi\\Cache\\Tests\\', __DIR__ . '/phpunit/Unit' );
$autoLoader->addPsr4( 'Onoi\\Cache\\Tests\\Integration\\', __DIR__ . '/phpunit/Integration' );
