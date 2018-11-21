<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/8
 * Time: 15:54
 *
 *                                _oo8oo_
 *                               o8888888o
 *                               88" . "88
 *                               (| -_- |)
 *                               0\  =  /0
 *                             ___/'==='\___
 *                           .' \\|     |// '.
 *                          / \\|||  :  |||// \
 *                         / _||||| -:- |||||_ \
 *                        |   | \\\  -  /// |   |
 *                        | \_|  ''\---/''  |_/ |
 *                        \  .-\__  '-'  __/-.  /
 *                      ___'. .'  /--.--\  '. .'___
 *                   ."" '<  '.___\_<|>_/___.'  >' "".
 *                  | | :  `- \`.:`\ _ /`:.`/ -`  : | |
 *                  \  \ `-.   \_ __\ /__ _/   .-` /  /
 *              =====`-.____`.___ \_____/ ___.`____.-`=====
 *                                `=---=`
 *
 *
 *             ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *                         佛祖保佑    永无BUG
 *
 */

namespace App\Admin\Controllers\Orders;


use App\Http\Controllers\Controller;
use App\Jobs\ProcessRefund;
use App\Models\OrderRefund;
use App\Models\ShopAdmin;
use Illuminate\Http\Request;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
use App\Models\Shop;

/**
 * @module 退单管理
 *
 * Class RefundController
 * @package App\Admin\Controllers\Orders
 */
class RefundController extends Controller
{
    /**
     * @permission 退单列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });

        $refunds = (new OrderRefund())->search($searcher)->latest()->where('shop_id',$show_shop_id)->paginate(10);
        $description = '已完成订单';

        return view('admin::orders.refunds', compact('refunds','header','description'));
    }

    /**
     * @permission 同意退款
     *
     * @param OrderRefund $refund
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agree(OrderRefund $refund, Request $request)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$refund)) {

            $refund->status = OrderRefund::AGREE;
            $refund->price = $request->get('price');
            $refund->save();

            dispatch(new ProcessRefund($refund));

            return response()->json(['status' => 1, 'message' => '已同意']);
        }else{
            return redirect()->route('admin::refunds.index');
        }
    }

    /**
     * @permission 拒绝退款
     *
     * @param OrderRefund $refund
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refuse(OrderRefund $refund, Request $request)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$refund)) {
            $refund->status = OrderRefund::REFUSE;
            $refund->refuse_reason = $request->get('refuse_reason');
            $refund->save();

            return response()->json(['status' => 1, 'message' => '已拒绝']);
        }else{
            return redirect()->route('admin::refunds.index');
        }
    }
}