<?php
namespace Brand\Standard\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * 无限分类
 * Class Limit
 * @package Stars\Peace\Entity
 */
class BrandArticleEntity extends Model
{


    protected $table ="brand_articles";

    protected $fillable = [ 'data_id', 'title' ,'tag' ,'summary' ,'content' ,'order' ,'status' , 'author_id','editor_id' ];

}
