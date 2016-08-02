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

use FastD\Storage\StorageInterface;

/**
 * Interface ProviderDriverInterface
 *
 * @package FastD\Middleware
 */
interface ProviderDriverInterface
{
    /**
     * @return StorageInterface
     */
    public function getStorageDriver();
}