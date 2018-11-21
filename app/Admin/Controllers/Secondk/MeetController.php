<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/3
 * Time: 16:12
 * Function:
 */

namespace App\Admin\Controllers\Secondk;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Mcategory;
use App\Models\Meet;
/**
 * @module 会场管理
 *
 * Class TopicController
 * @package App\Admin\Controllers\Items
 */
class MeetController extends Controller
{
    /**
     * @permission 会场列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $meets = Meet::paginate(10);

        return view('admin::secondk.meets', compact('meets'));
    }

    /**
     * @permission 创建会场-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $topics = Topic::all();
        $items = Item::all();
        return view('admin::secondk.meets-create', compact('topics','items'));
    }

    /**
     * @permission 创建会场
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $meet =new Meet();
        $meet->name = $request->get('name');
        $meet->topic_id = $request->get('topic_id');
        $meet->save();
        $itemIds = array_filter($request->get('items'));
        $meet->items()->sync($itemIds);

        return redirect()->route('admin::meets.index');
    }

    /**
     * @permission 修改会场-页面
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Meet $meet)
    {
        $topics = Topic::all();
        $items = Item::all();

        return view('admin::secondk.meets-edit', compact('meet', 'topics','items'));
    }

    /**
     * @permission 修改会场
     *
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Meet $meet)
    {
        $meet->name = $request->get('name');
        $meet->topic_id = $request->get('topic_id');
        $meet->save();
        $itemIds = array_filter($request->get('items'));
        if (!empty($itemIds)) {
            $meet->items()->sync($itemIds);
        }


        return redirect()->route('admin::meets.index');

    }

    /**
     * @permission 删除会场
     *
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Meet $meet)
    {

        $meet->delete();

        return response()->json(['status' => 1, 'message' => '成功']);
    }
}