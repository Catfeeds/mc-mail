<?php

namespace App\Admin\Controllers\Mall;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\About;

/**
 * @module 关于我们
 *
 * Class AboutController
 * @package App\Admin\Controllers\Base
 */
class AboutController extends Controller
{
    /**
     * @permission 关于我们
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $about = About::first();
        return view('admin::mall.about-edit',compact('about'));
    }

    public function update(Request $request,About $about)
    {
        $about->about_us = $request->about_us;
        $about->save();

        return redirect()->route('admin::about.index');
    }
}
