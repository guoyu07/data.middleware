<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

use FastD\Middleware\DataProvider;
use FastD\Middleware\Middleware;
use FastD\Storage\Driver\Redis\Redis;
use FastD\Storage\Driver\StorageDriver;

include __DIR__ . '/../vendor/autoload.php';

class MySQLMiddleware extends Middleware
{
    /**
     * 数据源, 所有缓存数据最终来源。
     *
     * @return mixed
     */
    public function dataOriginal()
    {
        return 'origin test';
    }
}

class RedisProvider extends DataProvider
{
    /**
     * RedisProvider constructor.
     *
     * @param StorageDriver|null $driver
     */
    public function __construct(StorageDriver $driver = null)
    {
        parent::__construct(new Redis([
            'host' => '11.11.11.22',
        ]));
    }

    public function getName()
    {
        return 'test';
    }

    /**
     * @return int
     */
    function weight()
    {
        return 40;
    }
}

$middleware = new MySQLMiddleware();
$middleware->append(new RedisProvider());
$data = $middleware->freshen();
print_r($data);
