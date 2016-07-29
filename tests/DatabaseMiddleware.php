<?php
use FastD\Database\Drivers\DriverInterface;
use FastD\Middleware\Middleware;

/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
class DatabaseMiddleware extends Middleware
{
    protected $driver;

    /**
     * DatabaseMiddleware constructor.
     *
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * 数据源, 所有缓存数据最终来源。
     *
     * @return mixed
     */
    public function dataOriginal()
    {
        $sql = 'select * from base';

        return $this->driver->query($sql)->execute()->getAll();
    }
}