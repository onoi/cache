# Cache

[![Build Status](https://secure.travis-ci.org/onoi/cache.svg?branch=master)](http://travis-ci.org/onoi/cache)
[![Code Coverage](https://scrutinizer-ci.com/g/onoi/cache/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/onoi/cache/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/onoi/cache/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/onoi/cache/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/onoi/cache/version.png)](https://packagist.org/packages/onoi/cache)
[![Packagist download count](https://poser.pugx.org/onoi/cache/d/total.png)](https://packagist.org/packages/onoi/cache)
[![Dependency Status](https://www.versioneye.com/php/onoi:cache/badge.png)](https://www.versioneye.com/php/onoi:cache)

A minimalistic cache interface that was part of the [Semantic MediaWiki][smw] code base and
is now deployed as independent library.

- Support for MediaWiki's `BagOStuff` cache
- Support for `Doctrine` cache clients
- Provides a [LRU][lru] `FixedInMemoryCache` array cache that can be used without any external dependency
- Provides a `CompositeCache` to combine different cache instances and allow an access by hierarchical iteration

## Requirements

PHP 5.3 or later

## Installation

The recommended installation method for this library is by using [Composer][composer].

```json
{
	"require": {
		"onoi/cache": "~1.0*"
	}
}
```

## Usage

The cache interface for all interactions is specified by `Onoi\Cache\Cache`.

```php
	class Foo {

		private $cache = null;

		public function __constructor( Onoi\Cache\Cache $cache ) {
			$this->cache = $cache;
		}

		public function doSomething( $id ) {

			if ( $this->cache->contains( $id ) ) {
				// do something
			}
		}
	}
```
```php
	$cacheFactory = new CacheFactory();

	$foo = new Foo( $cacheFactory->newFixedInMemoryCache( 500 ) );
	$foo->doSomething( 'bar' );
```
```php
	$cacheFactory = new CacheFactory();

	$compositeCache = $cacheFactory->newCompositeCache( array(
		$cacheFactory->newFixedInMemoryCache( 500 ),
		$cacheFactory->newMediaWikiCache( new \SqlBagOStuf() ),
		$cacheFactory->newDoctrineCache( new \Doctrine\Common\Cache\FileCache( '/C/Foo' ) )
	) );

	$foo = new Foo( $compositeCache );
	$foo->doSomething( 'bar' );

```

## Contribution and support

If you want to contribute work to the project please subscribe to the
developers mailing list and have a look at the [contribution guidelinee](/CONTRIBUTING.md). A list of people who have made contributions in the past can be found [here][contributors].

* [File an issue](https://github.com/onoi/cache/issues)
* [Submit a pull request](https://github.com/onoi/cache/pulls)

### Tests

The library provides unit tests that covers the core-functionality normally run by the [continues integration platform][travis]. Tests can also be executed manually using the PHPUnit configuration file found in the root directory.

## License

[GNU General Public License 2.0 or later][license].

[composer]: https://getcomposer.org/
[contributors]: https://github.com/onoi/cache/graphs/contributors
[license]: https://www.gnu.org/copyleft/gpl.html
[travis]: https://travis-ci.org/onoi/cache
[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki/
[lru]: https://en.wikipedia.org/wiki/Least_Recently_Used
