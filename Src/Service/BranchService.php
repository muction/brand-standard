<?php
namespace Brand\Standard\Service;

use Brand\Standard\Requests\RbacBranchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Traits\RbacUser;
use Illuminate\Http\Request;


class BranchService
{
    /**
     * 分页
     * @param Request $request
     * @return mixed
     */
    public function index( Request $request ){

        return RbacGroup::orderByDesc('updated_at')
            ->paginate( $request->input('size', 20 ) );
    }

    /**
     * 新增一个
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function branchStorage( Request $request , $id ){
        if(!$id ){
            return $this->create(  $request );
        }
        return $this->modify( $request , $id );

    }

    /**
     * 新增一个
     * @param RbacBranchRequest $request
     * @return mixed
     */
    private function create( RbacBranchRequest $request ){

        $name = $request->input('name') ;
        $displayName = $request->input('display_name') ;
        $rbacGroup = new RbacGroup();
        return $rbacGroup->storage( $name , $displayName );
    }

    /**
     * @param RbacBranchRequest $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    private function modify( RbacBranchRequest $request ,int $id ){

        $name = $request->input('name') ;
        $displayName = $request->input('display_name') ;
        $rbacGroup = new RbacGroup();
        $info = $rbacGroup->info( $id );
        if(!$info){
            throw new  \Exception("部门没有找到");
        }
        $info->name = $name ;
        $info->display_name = $displayName;
        $info->save();
        return $info;
    }

    /**
     * 删除
     * @param int $id
     * @return bool
     */
    public function remove( int $id ){
        $rbacGroup = new RbacGroup();
        $info = $rbacGroup->info( $id );
        if( $info){
            $info->delete();
        }
        return $info;
    }

}
