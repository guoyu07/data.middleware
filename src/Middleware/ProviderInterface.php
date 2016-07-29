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

/**
 * Interface ProviderInterface
 *
 * @package FastD\Middleware
 */
interface ProviderInterface
{
    /**
     * @return string
     */
    public function name();

    /**
     * @param $content
     * @return mixed
     */
    public function set($content);

    /**
     * @return mixed
     */
    public function get();

    /**
     * 权重级别
     *
     * @return int
     */
    public function weight();

    /**
     * @return bool
     */
    public function isHit();
}