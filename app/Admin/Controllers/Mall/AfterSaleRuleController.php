<?php

namespace App\Admin\Controllers\Mall;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleRule;

/**
 * @module 售后规则
 *
 * Class AfterSaleRuleController
 * @package App\Admin\Controllers\Mall
 */
class AfterSaleRuleController extends Controller
{
    /**
     * @permission 售后规则
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index() {
        $saleRule = SaleRule::first();

        $header = '售后规则';
        return view('admin::mall.after-sale-rule',compact('saleRule','header'));
    }

    /**
     * @param SaleRule $afterSaleRule
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaleRule $afterSaleRule,Request $request) {
        $afterSaleRule->content = $request->content;
        $afterSaleRule->save();

        return redirect()->route('admin::afterSaleRule.index');
    }
}
