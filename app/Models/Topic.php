<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/3
 * Time: 16:10
 * Function:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Mcategory;
use App\Models\Meet;
class Topic extends Model
{
    /**
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meets()
    {
        return $this->hasMany(Meet::class,'topic_id','id');
    }

    public function mcategory(){

        return $this->hasOne(Mcategory::class,'id','mcategory_id');
    }
}