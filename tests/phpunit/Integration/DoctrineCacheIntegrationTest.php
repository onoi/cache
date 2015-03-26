<?php

namespace Onoi\Cache\Tests\Integration;

use Doctrine\Common\Cache\ArrayCache;
use Onoi\Cache\DoctrineCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class DoctrineCacheIntegrationTest extends \PHPUnit_Framework_TestCase {

	public function testDoctrineArrayCache() {

		if ( !class_exists( '\Doctrine\Common\Cache\ArrayCache' ) ) {
			$this->markTestSkipped( 'ArrayCache is not available' );
		}

		$instance = new DoctrineCache( new ArrayCache() );

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
