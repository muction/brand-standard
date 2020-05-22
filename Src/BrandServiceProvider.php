<?php

namespace Brand\Standard;

use Brand\Standard\Exceptions\BrandExceptionHandler;
use Brand\Standard\Middleware\BrandMiddleware;
use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * 系统命令
     * @var array
     */
    protected $commands = [
        Console\Commands\Permissions::class
    ];

    /**
     * 系统中间件
     * @var array
     */
    protected $routeMiddleware = [
        'brand.middleware' => BrandMiddleware::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->runningInConsole()){
            $this->commands( $this->commands );
        }
        $this->registryExceptionHandler() ;

        $this->app->shouldSkipMiddleware();

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom( __DIR__ . "/Config/brandStandard.php", 'brand');
        $this->loadRoutesFrom( __DIR__ ."/Route.php");
        $this->loadViewsFrom( __DIR__."/Views/" ,'brand' );
        $this->registryRouteMiddleware();

        $this->publishes([
            __DIR__ . '/Config/brandStandard.php' => config_path('brandStandard.php'),
        ], 'brand-standard');
    }

    /**
     * 注册中间件
     */
    protected function registryRouteMiddleware(){

        foreach ( $this->routeMiddleware as $alias=>$class){
            app('router')->aliasMiddleware( $alias , $class);
        }
    }

    /**
     * 注册异常处理
     */
    protected function registryExceptionHandler(){

        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Exceptions\BrandExceptionHandler::class
        );
    }
}
