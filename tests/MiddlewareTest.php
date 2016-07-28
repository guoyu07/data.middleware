<?php

include_once __DIR__ . '/MysqlMiddleware.php';
include_once __DIR__ . '/LevelProvider1.php';
include_once __DIR__ . '/LevelProvider2.php';

/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
class MiddlewareTest extends PHPUnit_Framework_TestCase
{
    public function testMiddleware()
    {
        $middleware = new MysqlMiddleware();

        $this->assertEquals($middleware->invoke(), [
            'name' => 'jan'
        ]);
    }

    public function testLevel_1_Middleware()
    {
        $middleware = new MysqlMiddleware();

        $middleware->append(new LevelProvider1());

        $result = $middleware->invoke();

        $this->assertEquals($result, [
            'name' => 'jan for level 1'
        ]);
    }
}
