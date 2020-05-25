<?php
namespace Brand\Standard\Service;
use Brand\Standard\Entity\BrandArticleEntity;
use Brand\Standard\Exceptions\BrandNotFoundException;
use Brand\Standard\Response\Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Traits\RbacUser;
use Illuminate\Http\Request;
class BrandArticleService
{
    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function index( Request $request , $dataId ){
        return BrandArticleEntity::orderByDesc('order')
            ->where('status', 1)
            ->where('data_id', $dataId )
            ->get();
    }

    /**
     * 新增
     * @param Request $request
     * @param $dataId
     * @return mixed
     */
    public function storage( Request $request, $dataId , $id ){

        if($id >0){
            return $this->modify( $request , $dataId , $id );
        }
        return $this->create( $request , $dataId);
    }

    /**
     * 新增
     * @param Request $request
     * @param $dataId
     * @return mixed
     */
    private function create(Request $request, $dataId ){

        $stroage = $request->only([ 'title' ,'tag' ,'summary' ,'content' ,'order' ,'status' , 'author_id','editor_id' ]);
        $stroage['author_id'] = AdminService::loginUser('id');
        $stroage['editor_id'] = AdminService::loginUser('id');
        $stroage['data_id'] = $dataId;
        return BrandArticleEntity::create($stroage);
    }

    /**
     * 修改
     * @param Request $request
     * @param $dataId
     * @param $id
     * @return mixed
     */
    private function modify( Request $request, $dataId , $id ){
        $stroage = $request->only([ 'title' ,'tag' ,'summary' ,'content' ,'order' ,'status' , 'author_id','editor_id' ]);
        $stroage['editor_id'] = AdminService::loginUser('id');
        return BrandArticleEntity::where(['id'=>$id ,'data_id'=>$dataId ])->update($stroage);
    }

    /**
     * 删除
     * @param $dataId
     * @param $id
     * @return mixed
     */
    public function remove( $dataId, $id ){
        return BrandArticleEntity::where(['id'=>$id ,'data_id'=>$dataId ])->delete();
    }
}
