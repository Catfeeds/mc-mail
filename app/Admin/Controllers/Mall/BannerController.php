<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/20
 * Time: 17:12
 * Function:
 */

namespace App\Admin\Controllers\Mall;


use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

/**
 * @module 轮播图
 *
 * Class BannerController
 * @package App\Admin\Controllers\Home
 */
class BannerController extends Controller
{
    /**
     * @var array
     */
    protected $types = [
        'url' => '链接',
        'goods' => '商品ID'
    ];

    /**
     * @permission 轮播图列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin::home.banners', compact('banners'));
    }

    /**
     * @permission 新增轮播图-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $types = $this->types;
        return view('admin::home.banner-create', compact('types'));
    }

    /**
     * @permission 新增轮播图
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $banner = new Banner();
        $banner->order = $request->order;
        $banner->status = $request->status;
        $banner->redirect = [
            'target' => $request->target,
            'type' => $request->type
        ];

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banner', 'public');
            $banner->path = $path;
        }

        $banner->save();

        return redirect()->route('admin::banners.index');
    }

    /**
     * @permission 修改轮播图-页面
     *
     * @param Banner $banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Banner $banner)
    {
        $types = $this->types;
        return view('admin::home.banner-edit', compact('banner', 'types'));
    }

    /**
     * @permission 修改轮播图
     *
     * @param Banner $banner
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Banner $banner, Request $request)
    {
        $banner->order = $request->order;
        $banner->status = $request->status;
        $banner->redirect = [
            'target' => $request->target,
            'type' => $request->type
        ];

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banner', 'public');
            $banner->path = $path;
        }

        $banner->save();

        return redirect()->route('admin::banners.index');
    }

    /**
     * @permission 删除轮播图
     *
     * @param Banner $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json(['status' => 1, 'message' => '成功']);
    }
}