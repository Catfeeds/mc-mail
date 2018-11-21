<?php

namespace App\Admin\Controllers\Mall;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

/**
 * @module 服务条款
 *
 * Class ServiceController
 * @package App\Admin\Controllers\Mall
 */
class ServiceController extends Controller
{
    /**
     * @permission 服务条款
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $service = Service::first();

        $header = '服务条款';
        return view('admin::mall.service',compact('service','header'));
    }

    /**
     * @param Service $service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Service $service,Request $request) {
        $service->content = $request->content;
        $service->save();

        return redirect()->route('admin::service.index');
    }
}
