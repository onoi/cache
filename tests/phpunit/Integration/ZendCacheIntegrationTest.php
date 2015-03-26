<?php

namespace Onoi\Cache\Tests\Integration;

use Zend\Cache\StorageFactory;
use Onoi\Cache\ZendCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class ZendCacheIntegrationTest extends \PHPUnit_Framework_TestCase {

	public function testZendMemoryCache() {

		if ( !class_exists( '\Zend\Cache\StorageFactory' ) ) {
			$this->markTestSkipped( 'StorageFactory is not available' );
		}

		$memoryCache = StorageFactory::factory( array(
			'adapter' => array(
				'name'    => 'memory',
				'options' => array( 'ttl' => 100 ),
			),
				'plugins' => array(
				'exception_handler' => array( 'throw_exceptions' => false ),
			),
		) );

		$instance = new ZendCache( $memoryCache );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);

		$instance->save( 'Foo', 'Bar', 42 );

		$this->assertTrue(
			$instance->contains( 'Foo' )
		);

		$this->assertEquals(
			'Bar',
			$instance->fetch( 'Foo' )
		);

		$instance->delete( 'Foo' );

		$this->assertFalse(
			$instance->contains( 'Foo' )
		);
	}

}
