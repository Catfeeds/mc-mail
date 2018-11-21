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
/**
 * @module 专题管理
 *
 * Class TopicController
 * @package App\Admin\Controllers\Items
 */
class TopicController extends Controller
{
    /**
     * @permission 专题列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $topics = Topic::paginate(10);

        return view('admin::items.topics', compact('topics'));
    }

    /**
     * @permission 创建专题-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
       // $items = Item::all();
        $mcategories = Mcategory::all();
        return view('admin::items.topic-create', compact('mcategories'));
    }

    /**
     * @permission 创建专题
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $top = new Topic();
        $top->name = $request->get('name');
        $top->mcategory_id = $request->get('mcategory_id');
        $top->label = $request->get('label');

        $top->killtime = implode(',',$request->get('killtime'));
        $top->canceltime =  $request->get('canceltime');
        $top->status = $request->get('status');
        $top->save();

        return redirect()->route('admin::topics.index');
    }

    /**
     * @permission 修改专题-页面
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Topic $topic)
    {

        $mcategories = Mcategory::all();  $mcategories = Mcategory::all();
        $killtimes = explode(',',$topic->killtime);
        $killtimes = json_encode($killtimes);
        return view('admin::items.topic-edit', compact('topic', 'mcategories','killtimes'));
    }

    /**
     * @permission 修改专题
     *
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Topic $topic)
    {
        $topic->name = $request->get('name');
        $topic->mcategory_id = $request->get('mcategory_id');
        $topic->label = $request->get('label');

        $topic->killtime = implode(',',$request->get('killtime'));
        $topic->canceltime =  $request->get('canceltime');
        $topic->status = $request->get('status');
        $topic->save();

        return redirect()->route('admin::topics.index');

    }

    /**
     * @permission 删除专题
     *
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Topic $topic)
    {

        $topic->delete();

        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 秒杀点
     *
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Topic $topic){
        $killtimes = explode(',',$topic->killtime);
        $killtimes = json_encode($killtimes);
        return $killtimes;
    }
}