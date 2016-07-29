<?php
use FastD\Middleware\ProviderInterface;

/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
class CacheLevel1 implements ProviderInterface
{

    /**
     * @return string
     */
    public function name()
    {
        return 'db.cache.level.1';
    }

    /**
     * @param $content
     * @return mixed
     */
    public function set($content)
    {

    }

    /**
     * @return mixed
     */
    public function get()
    {
        // TODO: Implement get() method.
    }

    /**
     * 权重级别
     *
     * @return int
     */
    public function weight()
    {
        // TODO: Implement weight() method.
    }

    /**
     * @return bool
     */
    public function isHit()
    {
        // TODO: Implement isHit() method.
    }
}