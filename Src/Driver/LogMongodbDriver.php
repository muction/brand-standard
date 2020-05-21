<?php namespace Brand\Standard\Driver;

use Brand\Standard\Driver\Processor\BrandProcessor;
use Monolog\Logger;
use Monolog\Handler\MongoDBHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;

class LogMongodbDriver
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger(env('APP_NAME')); // 创建 Logger
        $handler = new MongoDBHandler( // 创建 Handler
            new \MongoDB\Client($config['server']), // 创建 MongoDB 客户端（依赖 mongodb/mongodb）
            $config['database'],
            $config['collection']
        );
      //  $logger->setTimezone( config('timezone') );
        $handler->setLevel($config['level']);
        $logger->pushHandler($handler); // 挂载 Handler
        $logger->pushProcessor( new BrandProcessor( $_SERVER) );
        return $logger;
    }
}
