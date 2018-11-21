<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Tanmo\Admin\Facades\Admin;
use Tanmo\Admin\Controllers\Main;

/**
 * @module 管理后台
 *
 * Class HomeController
 * @package App\Admin\Controllers
 */
class HomeController extends Controller
{
    /**
     * @permission 主页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(Admin::user()->isAdmin()){
            $ip = getIp();
            Redis::set($ip."show_shop_id",1);
        }
        return redirect()->route('admin::orders.statistics');
        return Main::envs();
    }
}