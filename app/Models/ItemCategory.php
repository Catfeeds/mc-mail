<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tanmo\Search\Traits\Search;

class ItemCategory extends Model
{
    use Search, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name','parent_id'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function parent(){

        return $this->hasOne(ItemCategory::class,'id','parent_id');
    }
    public function childrens(){

        return $this->hasMany(ItemCategory::class,'parent_id','id');
    }
}
