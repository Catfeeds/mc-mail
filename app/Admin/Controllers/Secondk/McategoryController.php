<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/13
 * Time: 15:48
 * Function:
 */

namespace App\Admin\Controllers\Secondk;


use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
use App\Models\Mcategory;
/**
 * @module 秒杀分类管理
 *
 * Class CategoryController
 * @package App\Admin\Controllers\Items
 */
class McategoryController extends Controller
{
    /**
     * @permission 分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $header = '秒杀分类管理';
        $mcategories = (new Mcategory())->orderBy('created_at','desc')->paginate(10);
        return view('admin::secondk.mcategory',compact('mcategories','header'));
    }

    /**
     * @permission 分类编辑-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Mcategory $mcategory){
        return dd('d');
    }



    /**
     * @permission 分类创建
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        $mcategory = new Mcategory();
        $mcategory->title = $request->get('title');
        $mcategory->save();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 分类编辑
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Mcategory $mcategory,Request $request){
        $mcategory->title = $request->get('title');
        $mcategory->save();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 分类删除
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Mcategory $mcategory){
        $mcategory->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }



}