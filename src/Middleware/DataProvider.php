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

use FastD\Storage\Cache;
use FastD\Storage\CacheInterface;
use FastD\Storage\Driver\StorageDriver;
use FastD\Storage\Storage;

/**
 * Class DataProvider
 *
 * @package FastD\Middleware
 */
abstract class DataProvider implements ProviderDriverInterface
{
    /**
     * @var Storage
     */
    protected $storage;

    /**
     * DataProvider constructor.
     *
     * @param StorageDriver $driver
     */
    public function __construct(StorageDriver $driver)
    {
        $this->storage = new Storage($driver);
    }

    /**
     * @return string
     */
    abstract function getName();

    /**
     * @return int
     */
    abstract function weight();

    /**
     * @return Storage
     */
    public function getStorageDriver()
    {
        return $this->storage;
    }

    /**
     * @return CacheInterface
     */
    public function get()
    {
        return $this->getStorageDriver()->getCache($this->getName())->getContent();
    }

    /**
     * @param $content
     * @return $this
     */
    public function set($content)
    {
        $this->getStorageDriver()->setCache(new Cache($this->getName(), $content));

        return $this;
    }

    /**
     * @return mixed
     */
    public function isHit()
    {
        return $this->getStorageDriver()->getCache($this->getName())->isHit();
    }
}