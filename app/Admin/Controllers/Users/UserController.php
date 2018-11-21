<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/26
 * Time: 17:01
 * Function:
 */

namespace App\Admin\Controllers\Users;


use App\Models\User;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
use App\Models\UserLevel;
use Illuminate\Http\Request;

/**
 * @module 会员管理
 *
 * Class UserController
 * @package App\Api\Controllers\Users
 */
class UserController
{
    /**
     * @permission 会员列表
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

        $users = (new User())->search($searcher)->latest()->paginate(10);

        return view('admin::users.users', compact('users'));
    }

    /**
     * @permission 会员编辑
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $userLevels = UserLevel::all();

        $header = '编辑会员';
        return view('admin::users.user-edit',compact('user','header','userLevels'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user,Request $request)
    {
        $user->update($request->all());
        return redirect()->route('admin::users.index');
    }
}