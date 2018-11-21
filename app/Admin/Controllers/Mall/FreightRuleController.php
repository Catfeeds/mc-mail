<?php

namespace App\Admin\Controllers\Mall;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreightRule;

/**
 * @module 运费规则
 *
 * Class FreightRuleController
 * @package App\Admin\Controllers\Mall
 */
class FreightRuleController extends Controller
{
    /**
     * @permission 运费规则
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $freightRule = FreightRule::first();

        $header = '运费规则';
        return view('admin::mall.freight-rule',compact('freightRule','header'));
    }

    /**
     * @param FreightRule $freightRule
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FreightRule $freightRule,Request $request) {
        $freightRule->content = $request->content;
        $freightRule->save();

        return redirect()->route('admin::freightRule.index');
    }
}
