<?php

namespace Onoi\Cache\Tests\Integration;

use HashBagOStuff;
use Onoi\Cache\MediaWikiCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class MediaWikiCacheIntegrationTest extends \PHPUnit_Framework_TestCase {

	public function testHashBagOStuff() {

		if ( !class_exists( '\HashBagOStuff' ) ) {
			$this->markTestSkipped( 'HashBagOStuff is not available' );
		}

		$instance = new MediaWikiCache( new HashBagOStuff() );

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
