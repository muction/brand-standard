<?php

namespace Brand\Standard\Console\Commands;

use Brand\Standard\Service\AdminService;
use Brand\Standard\Service\PermissionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Rbac\Standard\Entity\RbacPermission;

class Permissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:permission-init';

    /**
     * The console command description.
     *  权限会全部读取路由表所有信息
     * @var string
     */
    protected $description = '初始化权限';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("开始处理...");
        $routers= Route::getRoutes() ->get();
        foreach ($routers as $route){
            if(isset( $route->action['as'])){
                $perName =  $route->action['as'] ;

                if( RbacPermission::where('name', $perName)->count() ){
                    $this->warn( "略过：权限已存在 {$perName} ");
                    continue;
                }
                $permission =[
                    'name' => $route->action['as'],
                    'display_name'=>$route->action['as'],
                    'type' => PermissionService::PERMISSION_TYPE_ACTION_ID
                ];

                if( !RbacPermission::create($permission) ){
                    $this->error("失败：{$perName}");
                    continue;
                }
                $this->info("成功：{$perName}");
            }
        }
        $this->info("处理完成");
    }
}
