<?php

namespace App\Models;

use Tanmo\Admin\Models\Administrator;

class ShopAdmin extends Administrator
{

    public function shop(){
        return $this->hasOne(Shop::class,'admin_id','id');
    }
}