# Data Middleware

数据中间件, 用于数据库数据缓存缓存。

在日常生活中, 通常会接触到一个 "缓存" 的操作, 而大部分是时候操作, 都是判断缓存是否命中, 否则下一层缓存, 再否则查询数据库, 然后返回数据。

而基本上, 都是 `if`, `else` 操作, 因此才有了这个数据中间件的想法, 用来封装数据提供及缓存处理。

### composer

```
composer require -vvv "fastd/data-middleware:1.0.x-dev"
```

### 基础使用

```php
<?php

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
$data = $middleware->resolve();
var_dump($data); // origin test
```

`Middleware` 对象提供最底层数据, 如果设置的所有缓存不能命中, 那就会返回 `Middleware` 对象中的 `dataOriginal` 方法, 由方法直接返回数据。

如果命中失败, 返回的数据会存储到所有缓存中, 预备下一次的操作。

`DataProvider` 缓存数据提供器, 目前支持的驱动来自于 `fastd/storage` 组件。默认链接本地 redis 驱动, 若需要自定义驱动, 重写构造方法即可。

`getName` 返回缓存名字, 若 `getName` 数据为存储合法的数据, 则命中, 反之。

`weight` 缓存权重, 类似多级缓存中的级别, 权重越高, 越靠前。

执行数据缓存中间件操作调用 `resolve`, 系统会自动调用所有级别缓存进行命中判断返回数据。

中间件提供缓存数据刷新: `freshen` 强制刷新所有缓存数据.

# License MIT
