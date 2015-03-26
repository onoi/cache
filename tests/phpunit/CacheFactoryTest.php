<?php

namespace Onoi\Cache\Tests;

use Onoi\Cache\CacheFactory;

/**
 * @covers \Onoi\Cache\CacheFactory
 *
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CacheFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\Cache\CacheFactory',
			new CacheFactory()
		);

		$this->assertInstanceOf(
			'\Onoi\Cache\CacheFactory',
			CacheFactory::getInstance()
		);
	}

	public function testClear() {

		$instance = CacheFactory::getInstance();

		$this->assertSame(
			$instance,
			CacheFactory::getInstance()
		);

		$instance->clear();

		$this->assertNotSame(
			$instance,
			CacheFactory::getInstance()
		);
	}

	public function testCanConstructMediaWikiCache() {

		if ( !class_exists( '\BagOstuff' ) ) {
			$this->markTestSkipped( 'BagOstuff interface is not avilable' );
		}

		$cache = $this->getMockBuilder( '\BagOstuff' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance =	new CacheFactory();

		$this->assertInstanceOf(
			'\Onoi\Cache\MediaWikiCache',
			$instance->newMediaWikiCache( $cache )
		);
	}

	public function testCanConstructDoctrineCache() {

		if ( !interface_exists( '\Doctrine\Common\Cache\Cache' ) ) {
			$this->markTestSkipped( 'Doctrine cache interface is not avilable' );
		}

		$cache = $this->getMockBuilder( '\Doctrine\Common\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance =	new CacheFactory();

		$this->assertInstanceOf(
			'\Onoi\Cache\DoctrineCache',
			$instance->newDoctrineCache( $cache )
		);
	}

	public function testCanConstructFixedInMemoryCache() {

		$instance =	new CacheFactory();

		$this->assertInstanceOf(
			'\Onoi\Cache\FixedInMemoryCache',
			$instance->newFixedInMemoryCache( 1 )
		);
	}

	public function testCanConstructCompositeCache() {

		$instance =	new CacheFactory();

		$cache = array(
			$instance->newFixedInMemoryCache()
		);

		$this->assertInstanceOf(
			'\Onoi\Cache\CompositeCache',
			$instance->newCompositeCache( $cache )
		);
	}

	public function testCanConstructNullCache() {

		$instance =	new CacheFactory();

		$this->assertInstanceOf(
			'\Onoi\Cache\NullCache',
			$instance->newNullCache()
		);
	}

}
