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
        // TODO: Implement dataOriginal() method.
    }
}

class RedisProvider extends DataProvider
{
    public function getName()
    {
        return 'test';
    }
}

$middleware = new MySQLMiddleware();
$middleware->append(new RedisProvider());
$middleware->resolve();