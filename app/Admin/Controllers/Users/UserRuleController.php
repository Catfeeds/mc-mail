<?php

namespace App\Admin\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRule;

/**
 * @module 会员管理
 *
 * Class UserRoleController
 * @package App\Http\Controllers
 */
class UserRuleController extends Controller
{
    /**
     * @permission 会员规则
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $userRule = UserRule::first();

        $header = '会员规则';
        return view('admin::users.users-rule',compact('userRule','header'));
    }

    /**
     * @param UserRule $userRule
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRule $userRule,Request $request) {
        $userRule->content = $request->get('content');
        $userRule->save();

        return redirect()->route('admin::userRules.index');
    }
}
