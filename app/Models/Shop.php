<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tanmo\Search\Traits\Search;

class Shop extends Model{

    use Search;
    protected $guarded=[];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admin(){
        return $this->belongsTo(ShopAdmin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order(){
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(){
        return $this->hasMany(User::class);
    }
}
