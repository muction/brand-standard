<?php
namespace Brand\Standard\Entity;

use Brand\Standard\Response\Error;
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

    /**
     * 所有附件
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(){
        return $this->hasMany(AttachmentEntity::class , 'data_id' ,'id')
            ->where('data_type', configStandard('category.data_type.brand'))
            ->where('status',  Error::STATUS_VALID );
    }
}
