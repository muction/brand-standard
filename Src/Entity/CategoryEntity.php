<?php
namespace Brand\Standard\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * 无限分类
 * Class Limit
 * @package Stars\Peace\Entity
 */
class CategoryEntity extends Model
{
    use TraitCategory;

    protected $table ="categories";

    protected $fillable = [ 'title' ,'summary' ,'icon' ,'parent_id'  ,'data_type' ,'order' ,'status' , 'author_id','editor_id' ];

    /**
     * 包含的内容
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brandArticles(){
        return $this->hasMany(ArticleEntity::class , 'id','data_id')
            ->orderByDesc('order')
            ->select(['id','title'])
            ->where('data_type', configStandard('category_type.type.brand' ) );
    }
}
