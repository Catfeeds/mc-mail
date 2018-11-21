<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/13
 * Time: 15:48
 * Function:
 */

namespace App\Admin\Controllers\Items;


use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 分类管理
 *
 * Class CategoryController
 * @package App\Admin\Controllers\Items
 */
class CategoryController extends Controller
{
    /**
     * @permission 分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('id');
            $searcher->like('name');
        });

        $categories = (new ItemCategory())->search($searcher)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin::items.categories', compact('categories','searcher'));
    }

    /**
     * @permission 新增分类-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = (new ItemCategory())->where('parent_id','=',0)->get();

        return view('admin::items.category-create',compact('categories'));
    }

    /**
     * @permission 新增分类
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $count = (new ItemCategory())->where('id','=',$request->parent_id)->count();
        if(($count!=0 && $request->parent_id)|| $request->parent_id ==0) {
            ItemCategory::create(['name' => $request->name, 'parent_id' => $request->parent_id]);
        }
        return redirect()->route('admin::categories.index');
    }

    /**
     * @permission 修改分类-页面
     *
     * @param ItemCategory $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ItemCategory $category)
    {
        $categories = (new ItemCategory())->where('parent_id','=',0)->where('id','!=',$category->id)->get();
        return view('admin::items.category-edit', compact('category','categories'));
    }

    /**
     * @permission 修改分类
     *
     * @param ItemCategory $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ItemCategory $category, Request $request)
    {
        $count = (new ItemCategory())->where('id','=',$request->parent_id)->count();
        if(($count!=0 && $request->parent_id)|| $request->parent_id ==0) {
            $category->name = $request->get('name');
            $category->parent_id = $request->get('parent_id');
            $category->save();
        }

        return redirect()->route('admin::categories.index');
    }

    /**
     * @permission 删除分类
     *
     * @param ItemCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ItemCategory $category)
    {
        $category->delete();

        return response()->json(['status' => 1, 'message' => '成功']);
    }

}