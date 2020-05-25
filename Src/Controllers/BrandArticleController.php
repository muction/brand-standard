<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\BrandArticleRequest;
use Brand\Standard\Requests\CategoryRequest;
use Brand\Standard\Service\BrandArticleService;
use Brand\Standard\Service\CategoryService;
use Illuminate\Http\Request;

/**
 * 品牌正文管理控制器
 * Class AdminController
 * @package Brand\Standard\Controllers
 */
class BrandArticleController extends Controller
{
    /**
     * @param Request $request
     * @param BrandArticleService $brandArticleService
     * @param $dataId
     * @return array
     */
    public function index( Request $request , BrandArticleService $brandArticleService, $dataId ){

        return $this->responseSuccess(
            $brandArticleService->index( $request, $dataId )
        );
    }

    /**
     * @param BrandArticleRequest $request
     * @param BrandArticleService $brandArticleService
     * @param $dataId
     * @return array
     */
    public function storage( BrandArticleRequest $request , BrandArticleService $brandArticleService , $dataId ){
        return $this->responseSuccess(
            $brandArticleService->storage( $request, $dataId , 0)
        );
    }

    /**
     * @param BrandArticleRequest $request
     * @param BrandArticleService $brandArticleService
     * @param $dataId
     * @param $id
     * @return array
     */
    public function modify( BrandArticleRequest $request , BrandArticleService $brandArticleService , $dataId , $id ){
        return $this->responseSuccess(
            $brandArticleService->storage( $request, $dataId , $id )
        );
    }

    /**
     * @param BrandArticleService $brandArticleService
     * @param $dataId
     * @param $id
     * @return array
     */
    public function remove( BrandArticleService $brandArticleService , $dataId , $id ){
        return $this->responseSuccess(
            $brandArticleService->remove( $dataId , $id )
        );
    }
}
