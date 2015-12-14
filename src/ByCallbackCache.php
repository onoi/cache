<?php

namespace Onoi\Cache;

use RuntimeException;
use Closure;

/**
 * @license GNU GPL v2+
 * @since 1.3
 *
 * @author mwjames
 */
class ByCallbackCache implements Cache {

	/**
	 * @var Cache
	 */
	private $cache = null;

	/**
	 * @var Closure
	 */
	private $callback = null;

	/**
	 * @since 1.3
	 *
	 * @param Cache $cache
	 */
	public function __construct( Cache $cache ) {
		$this->cache = $cache;
	}

	/**
	 * @since 1.3
	 *
	 * @param Closure $callback
	 */
	public function setCallback( Closure $callback ) {
		$this->callback = $callback;
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {

		if ( $this->contains( $id ) ) {
			return $this->cache->fetch( $id );
		}

		return call_user_func_array( $this->callback, array( $id, $this->cache ) );
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {
		return $this->cache->contains( $id );
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {
		$this->cache->save( $id, $data, $ttl );
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {
		$this->cache->delete( $id );
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return $this->cache->getStats();
	}

	/**
	 * @since  1.3
	 *
	 * {@inheritDoc}
	 */
	public function getName() {
		return __CLASS__ . '::' . $this->cache->getName();
	}

}
