<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\ByCallbackCache;

/**
 * @covers \Onoi\Cache\ByCallbackCache
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.3
 *
 * @author mwjames
 */
class ByCallbackCacheTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$this->assertInstanceOf(
			'\Onoi\Cache\ByCallbackCache',
			new ByCallbackCache( $cache )
		);
	}

	public function testFetchWithCallback() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->at( 2 ) )
			->method( 'contains' )
			->will( $this->returnValue( true ) );

		$cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->equalTo( 42 ),
				$this->anything() )
			->will( $this->returnValue( 42 ) );

		$instance = new ByCallbackCache( $cache );
		$instance->setCallback( function( $id, $cache ) {

			$value = $id === 'Foo' ? 42 : 'bar';
			$cache->save( $id, $value );

			return $value;
		} );

		$this->assertEquals(
			42,
			$instance->fetch( 'Foo' )
		);

		// Second invoke doesn't reach the callback
		$instance->fetch( 'Foo' );
	}

	public function testGetName() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'getName' );

		$instance = new ByCallbackCache( $cache );
		$instance->getName();
	}

	public function testSave() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'Foo' ),
				$this->equalTo( 42 ),
				$this->equalTo( 1001 ) );

		$instance = new ByCallbackCache( $cache );
		$instance->save( 'Foo', 42, 1001 );
	}

	public function testDelete() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'delete' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new ByCallbackCache( $cache );
		$instance->delete( 'Foo' );
	}

	public function testContains() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'contains' )
			->with(
				$this->equalTo( 'Foo' ) );

		$instance = new ByCallbackCache( $cache );
		$instance->contains( 'Foo' );
	}

	public function testGetStats() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'getStats' );

		$instance = new ByCallbackCache( $cache );
		$instance->getStats();
	}

}
