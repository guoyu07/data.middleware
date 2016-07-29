<?php
use FastD\Middleware\ProviderInterface;
use FastD\Storage\File\File;

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
        File::open(__DIR__ . '/' . $this->name())->set(json_encode($content, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return 'from cache';
        return json_decode(File::open(__DIR__ . '/' . $this->name())->get(), true);
    }

    /**
     * 权重级别
     *
     * @return int
     */
    public function weight()
    {
        return 50;
    }

    /**
     * @return bool
     */
    public function isHit()
    {
        return true;
        return file_exists(__DIR__ . '/' . $this->name()) && filesize(__DIR__ . '/' . $this->name()) > 0;
    }
}