<?php
namespace Brand\Standard\Service;

use Brand\Standard\Entity\CategoryEntity;
use Brand\Standard\Exceptions\BrandNotFoundException;
use Brand\Standard\Response\Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Traits\RbacUser;
use Illuminate\Http\Request;

class CategoryService
{
    /**
     * @param Request $request
     * @param int $id
     * @return array|mixed
     * @throws BrandNotFoundException
     */
    public function storage(Request $request, $id=0){
        if( $id >0){
            return $this->modify( $request, $id );
        }
        return $this->create( $request );
    }

    /**
     * 新增
     * @param Request $request
     * @return array
     */
    public function create(Request $request){

        $category=new CategoryEntity();
        $stroage=$request->only(['title' ,'summary' ,'icon' ,'parent_id'  ,'type' ,'order' ,'status']);
        $stroage['author_id'] = AdminService::loginUser('id');
        $stroage['editor_id'] = AdminService::loginUser('id');
        return $category->creteNodes( $stroage );
    }

    /**
     * 编辑分类
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws BrandNotFoundException
     */
    public function modify( Request $request, $id){

        $info= CategoryEntity::where('id', $id)->first();
        if(!$info){
            throw new BrandNotFoundException();
        }

        $stroage=$request->only(['title' ,'summary' ,'icon' ,'parent_id'  ,'type' ,'order' ,'status']);
        $stroage['editor_id'] = AdminService::loginUser('id');

        return $info->update( $stroage ) ;
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     * @throws BrandNotFoundException
     */
    public function remove( $id ){
        $info= CategoryEntity::where('id', $id)->first();
        if(!$info){
            throw new BrandNotFoundException();
        }

        return $info->delete();
    }
}
