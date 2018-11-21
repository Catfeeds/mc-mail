<?php

namespace App\Admin\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLevel;
use App\Models\User;
use App\Models\ItemCategory;
use Tanmo\Search\Query\Searcher;
use Tanmo\Search\Facades\Search;

/**
 * @module 会员等级列表
 *
 * Class UserLevelController
 * @package App\Admin\Controllers\Users
 */
class UserLevelController extends Controller
{
    /**
     * @permission 会员等级列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('level');
            $searcher->like('name');
        });

        $start = request()->get('start');
        $end = request()->get('end');
        $userLevels = (new UserLevel())->search($searcher)->TimeInterval($start,$end)->orderBy('level','desc')->paginate(10);

        $header = '会员等级列表';
        return view('admin::users.userLevels',compact('userLevels','header'));
    }

    /**
     * @permission 新增会员等级-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $itemCategories = ItemCategory::all();

        $header = '新增会员等级';
        return view('admin::users.userLevel-create',compact('header','itemCategories'));
    }

    /**
     * @permission 新增会员等级
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['level'] = $request->level;
        $data['date_num'] = $request->date_num;
        $data['date_money'] = $request->date_money;
        if($request->brands) {
            $data['brands'] = implode(",",$request->brands);
        }
        $data['brands_money'] = $request->brands_money;
        $data['upgrade_condition'] = $request->upgrade_condition;

        UserLevel::create($data);
        return redirect()->route('admin::userLevels.index');
    }

    /**
     * @permission 编辑会员等级-页面
     *
     * @param UserLevel $userLevel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserLevel $userLevel)
    {
        if($userLevel->level == 0) {
            return redirect()->route('admin::userLevels.index');
        }

       $header = '编辑会员等级';
       return view('admin::users.
       $itemCategories = ItemCategory::all();userLevel-edit',compact('userLevel','itemCategories','header'));
    }

    /**
     * @permission 编辑会员等级
     *
     * @param UserLevel $userLevel
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserLevel $userLevel,Request $request)
    {
        $level = $userLevel->level;
        $data['name'] = $request->name;
        $data['level'] = $request->level;
        $data['date_num'] = $request->date_num;
        $data['date_money'] = $request->date_money;
        if ($request->brands) {
            $data['brands'] = implode(",", $request->brands);
        }
        $data['brands_money'] = $request->brands_money;
        $data['upgrade_condition'] = $request->upgrade_condition;

        $res = $userLevel->update($data);
        if ($userLevel->level != $level && $res) {
            User::where('level', $level)->update(['level' => $userLevel->level]);
        }
        return redirect()->route('admin::userLevels.index');

    }

    /**
     * @param UserLevel $userLevel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserLevel $userLevel)
    {
        if($userLevel->level == 0) {
            return response()->json(['message' => '删除失败,基础等级不可删除','status' => 0]);
        }
        if(!$userLevel->users->isEmpty()) {
            return response()->json(['message' => '删除失败,存在该等级的会员','status' => 0]);
        }
        $userLevel->delete();
        return response()->json(['message' => '删除成功','status' => 1]);
    }

    /**
     * @return string
     */
    public function checkName()
    {
        if(request()->get('current_name')) {
            if(request()->get('current_name') == request()->get('name')) {
                return '{"valid":true}';
            }
        }

        $user = UserLevel::where('name',request()->get('name'))->first();
        if($user) {
            return '{"valid":false}';
        }
        return '{"valid":true}';
    }

    /**
     * @return string
     */
    public function checkLevel()
    {
        if(request()->get('current_level')) {
            if(request()->get('current_level') == request()->get('level')) {
                return '{"valid":true}';
            }
        }

        $user = UserLevel::where('level',request()->get('level'))->first();
        if($user) {
            return '{"valid":false}';
        }
        return '{"valid":true}';
    }
}
