<?php

namespace Onoi\Cache;

use BagOStuff;

/**
 * MediaWiki BagOStuff decorator
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class MediaWikiCache implements Cache {

	/**
	 * @var BagOStuff
	 */
	private $cache = null;

	/**
	 * @note MediaWiki's BagOStuff doesn't know any has/contains function therefore
	 * we need to use an internal array the fetch and temporarily store the results
	 * to ensure no expensive lookups occur for the same key
	 *
	 * @var array
	 */
	private $inMemoryCache = array();

	/**
	 * @var integer
	 */
	private $count = 0;

	/**
	 * @var integer
	 */
	private $cacheHits = 0;

	/**
	 * @var integer
	 */
	private $cacheMisses = 0;

	/**
	 * @since 1.0
	 *
	 * @param BagOStuff $cache
	 */
	public function __construct( BagOStuff $cache ) {
		$this->cache = $cache;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {

		if ( $this->contains( $id ) ) {
			$this->cacheHits++;
			return $this->inMemoryCache[ $id ];
		}

		$this->cacheMisses++;
		return false;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {

		if ( isset ( $this->inMemoryCache[ $id ] ) || array_key_exists( $id, $this->inMemoryCache ) ) {
			return true;
		}

		$this->inMemoryCache[ $id ] = $this->cache->get( $id );

		return !$this->inMemoryCache[ $id ] ? false : true;
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {
		$this->count++;
		$this->cache->set( $id, $data, $ttl );
		unset( $this->inMemoryCache[ $id ] );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {
		$this->count--;
		$this->cache->delete( $id );
		unset( $this->inMemoryCache[ $id ] );
	}

	/**
	 * @since  1.0
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return array(
			'count'  => $this->count,
			'hits'   => $this->cacheHits,
			'misses' => $this->cacheMisses
		);
	}

}
