<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Middleware;

use FastD\Database\Cache\CacheInterface;
use FastD\Storage\Redis\Redis;

/**
 * Class DataProvider
 *
 * @package FastD\Middleware
 */
abstract class DataProvider implements ProviderDriverInterface
{
    /**
     * @var CacheInterface
     */
    protected static $driver;

    /**
     * @return string
     */
    abstract function getName();

    /**
     * @return int
     */
    abstract function weight();

    /**
     * @param array $config
     * @return CacheInterface
     */
    public function getDriver(array $config = [])
    {
        if (null === static::$driver) {
            static::$driver = new Redis($config);
        }

        return static::$driver;
    }

    public function get()
    {
        return $this->getDriver()->getCache($this->getName());
    }

    public function set($content)
    {
        return $this->getDriver()->set($content);
    }

    public function isHit()
    {

    }
}