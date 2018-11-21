<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\ShopAdmin;
use Tanmo\Admin\Models\Administrator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * @param ShopAdmin $shopAdmin
     * @param Order $order
     * @return bool
     */
    public function adminShop(ShopAdmin $shopAdmin, Item $item)
    {

        if($shopAdmin->isAdmin()){
            return true;
        }
//        dd($shopAdmin->shop->id);
//        dd($order->shop_id);

        return $shopAdmin->shop->id === $item->shop_id;
    }


}
