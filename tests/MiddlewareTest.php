<?php

use FastD\Database\Drivers\MySQLDriver;

include_once __DIR__ . '/MysqlMiddleware.php';
include_once __DIR__ . '/LevelProvider1.php';
include_once __DIR__ . '/LevelProvider2.php';

include_once __DIR__ . '/DatabaseMiddleware.php';
include_once __DIR__ . '/CacheLevel1.php';

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

        $this->assertEquals($middleware->resolve(), [
            'name' => 'jan'
        ]);
    }

    public function testLevel_1_Middleware()
    {
        $middleware = new MysqlMiddleware();

        $middleware->append(new LevelProvider1());

        $result = $middleware->resolve();

        $this->assertEquals($result, [
            'name' => 'jan for level 1'
        ]);
    }

    public function testLevel_2_Middleware()
    {
        $middleware = new MysqlMiddleware();

        $middleware->append(new LevelProvider2());
        $middleware->append(new LevelProvider1());

        $result = $middleware->resolve();

        $this->assertEquals($result, [
            'name' => 'jan for level 1'
        ]);
    }

    /**
     *
     */
    public function testDatabaseMiddleware()
    {
        $databaseMiddleware = new DatabaseMiddleware(new MySQLDriver([
            'database_host'      => '127.0.0.1',
            'database_port'      => '3306',
            'database_name'      => 'dbunit',
            'database_user'      => 'root',
            'database_pwd'       => '123456'
        ]));

        $noCache = $databaseMiddleware->resolve();

        $this->assertEquals([
            [
                'id' => '1',
                'name' => 'joe',
                'content' => 'Hello buddy!',
                'create_at' => '1272100523',
            ],
            [
                'id' => '2',
                'name' => 'janhuang',
                'content' => 'I like it!',
                'create_at' => '1272255260',
            ],
        ], $noCache);

        $databaseMiddleware->append(new CacheLevel1());

        $hasCache = $databaseMiddleware->resolve();
        $this->assertEquals('from cache', $hasCache);
        /*$this->assertEquals([
            [
                'id' => '1',
                'name' => 'joe',
                'content' => 'Hello buddy!',
                'create_at' => '1272100523',
            ],
            [
                'id' => '2',
                'name' => 'janhuang',
                'content' => 'I like it!',
                'create_at' => '1272255260',
            ],
        ], $hasCache);*/
    }
}
