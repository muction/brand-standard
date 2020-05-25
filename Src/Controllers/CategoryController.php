<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\CategoryRequest;
use Brand\Standard\Service\CategoryService;
use Illuminate\Http\Request;

/**
 * 分类管理控制器
 * Class AdminController
 * @package Brand\Standard\Controllers
 */
class CategoryController extends Controller
{
    /**
     * 新增分类
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @return array
     */
    public function categoryStorage( CategoryRequest $request, CategoryService $service ){

        return $this->responseSuccess(
            $service->storage( $request )
        );
    }

    /**
     * 修改分类
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param $id
     * @return array
     */
    public function categoryModify( CategoryRequest $request, CategoryService $service , $id ){
        return $this->responseSuccess(
            $service->storage( $request , $id )
        );
    }

    /**
     * 仅限删除分类，不删除子内容
     * @param CategoryService $service
     * @param $id
     * @return array
     * @throws \Brand\Standard\Exceptions\BrandNotFoundException
     */
    public function categoryRemove(CategoryService $service, $id ){
        return $this->responseSuccess(
            $service->remove( $id )
        );
    }
}
