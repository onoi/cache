<?php

namespace Onoi\Cache;

use Doctrine\Common\Cache\Cache as DoctrineCacheClient;
use BagOStuff;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CacheFactory {

	/**
	 * @var CacheFactory
	 */
	private static $instance = null;

	/**
	 * @since 1.0
	 *
	 * @return CacheFactory
	 */
	public static function getInstance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public static function clear() {
		self::$instance = null;
	}

	/**
	 * @since 1.0
	 *
	 * @param BagOStuff $cache
	 *
	 * @return MediaWikiCache
	 */
	public function newMediaWikiCache( BagOStuff $cache ) {
		return new MediaWikiCache( $cache );
	}

	/**
	 * @since 1.0
	 *
	 * @param DoctrineCacheClient $cache
	 *
	 * @return DoctrineCache
	 */
	public function newDoctrineCache( DoctrineCacheClient $cache ) {
		return new DoctrineCache( $cache );
	}

	/**
	 * @since 1.0
	 *
	 * @param integer $cacheSize
	 *
	 * @return FixedInMemoryCache
	 */
	public function newFixedInMemoryCache( $cacheSize = 500 ) {
		return new FixedInMemoryCache( $cacheSize );
	}

	/**
	 * @since 1.0
	 *
	 * @param Cache[] $caches
	 *
	 * @return CompositeCache
	 */
	public function newCompositeCache( array $caches ) {
		return new CompositeCache( $caches );
	}

}
