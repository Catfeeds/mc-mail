<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/26
 * Time: 17:01
 * Function:
 */

namespace App\Admin\Controllers\Shop;


use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Support\Facades\Redis;
use Tanmo\Admin\Facades\Admin;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 店铺管理
 *
 * Class UserController
 * @package App\Api\Controllers\Users
 */
class ShopController extends Controller
{
    /**
     * @permission 店铺列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('id');
            $searcher->like('nickname');
            $searcher->like('phone');
        });

        $shops = (new Shop())->search($searcher)->latest()->paginate(10);
        return view('admin::shop.shops', compact('shops'));
    }

    /**
     * @param Shop $shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Shop $shop)
    {
        if(!Admin::user()->isAdmin()) return;


        $ip = getIp();
        Redis::set($ip."show_shop_id",$shop->id);

        return redirect()->route('admin::orders.statistics',['show_shop_id'=>$shop->id]);
    }


}