<?php

namespace Brand\Standard;

use Brand\Standard\Middleware\BrandMiddleware;
use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * 系统命令
     * @var array
     */
    protected $commands = [];

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

        $this->app->shouldSkipMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom( __DIR__ ."/Config/config.php" , 'brand');
        $this->loadRoutesFrom( __DIR__ ."/Route.php");
        $this->loadViewsFrom( __DIR__."/Views/" ,'brand' );

        $this->registryRouteMiddleware();
    }

    /**
     * 注册中间件
     */
    protected function registryRouteMiddleware(){

        foreach ( $this->routeMiddleware as $alias=>$class){
            app('router')->aliasMiddleware( $alias , $class);
        }
    }
}
