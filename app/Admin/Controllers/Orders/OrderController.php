<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/8
 * Time: 16:03
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
use App\Models\Express;
use App\Models\Order;
use App\Models\Shop;
use App\Models\ShopAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tanmo\Admin\Facades\Admin;
use Tanmo\Admin\Models\Administrator;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 订单管理
 *
 * Class OrderController
 * @package App\Admin\Controllers\Orders
 */
class OrderController extends Controller
{

    public function index(){

    }


    /**
     *  @permission 待付款
     *
     * @param Shop $shop
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paying()
    {

        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });

        $orders = (new Order())->search($searcher)->filterStatus(Order::WAIT_PAY)->where('shop_id',$show_shop_id)->orderBy('created_at', 'desc')->paginate(10);

        $description = '待付款订单';
        return view('admin::orders.paying', compact('orders', 'header','shop','description'));
    }

    /**
     * @permission 待发货
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivering()
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });

        $orders = (new Order())->search($searcher)->filterStatus(Order::WAIT_DELIVER)->where('shop_id',$show_shop_id)->paginate(10);
        $description = '待发货订单';
        $expresses = Express::all();
        return view('admin::orders.delivering', compact('orders', 'header', 'expresses','description'));
    }

    /**
     * @permission 待收货
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function receiving()
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });


        $orders = (new Order())->search($searcher)->filterStatus(Order::WAIT_RECV)->where('shop_id',$show_shop_id)->paginate(10);
        $description = '待收货订单';
        return view('admin::orders.receiving', compact('orders', 'header','description'));
    }

    /**
     * @permission 待评价
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function commenting()
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });


        $orders = (new Order())->search($searcher)->filterStatus(Order::WAIT_COMMENT)->where('shop_id',$show_shop_id)->paginate(10);
        $description = '待评价订单';
        return view('admin::orders.commenting', compact('orders', 'header','description'));
    }

    /**
     * @permission 已完成
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish()
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }

        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('sn');
        });

        $orders = (new Order())->search($searcher)->filterStatus(Order::FINISH)->where('shop_id',$show_shop_id)->paginate(10);
        $description = '已完成订单';
        return view('admin::orders.finish', compact('orders', 'header','description'));
    }

    /**
     *
     * @permission 订单详情
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$order)){

            $header = '订单详情';
            return view('admin::orders.order-show', compact('order', 'header'));

        }else{
            return redirect()->route('admin::orders.paying');
        }

    }

    /**
     * @permission 修改价格
     *
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyPrice(Order $order, Request $request)
    {

        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$order)){

            $order->price = $request->get('price');
            $order->save();

            return response()->json(['status' => 1, 'message' => '成功']);
        }
        else{
            return response()->json(['status' => 0, 'message' => '您无权操作其他商铺订单']);
        }
}
    /**
     * @permission 发货
     *
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliver(Order $order, Request $request)
    {

        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$order)){

            $order->express_type = $request->get('express_type');
            $order->tracking_no = $request->get('tracking_no');
            $order->status = Order::WAIT_RECV;
            $order->delivered_at = Carbon::now();
            $order->save();

            return response()->json(['status' => 1, 'message' => '发货成功']);
        }
        else{
            return response()->json(['status' => 0, 'message' => '您无权操作其他商铺订单']);
        }
    }

    /**
     *
     * @permission 删除订单
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Order $order)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$order)){

            $order->delete();

            return response()->json(['status' => 1, 'message' => '成功']);
        }
        else{
            return response()->json(['status' => 0, 'message' => '您无权操作其他商铺订单']);
        }
    }

    /**
     * @permission 数据展示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistics(){

        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }


        $description = '数据展示';

//        if(Admin::user()->isAdmin()){
//            $show_shop_id = \request()->get('show_shop_id') ?? 1;
//        }else{
//            $show_shop_id = ShopAdmin::find(Admin::user()->id)->shop->id;
//        }
//mlog('text',$show_shop_id);

//        $today = strtotime(date("Y-m-d",time()));
//        $yesterday = strtotime(date("Y-m-d",time()-60*60*24));
//        $sevenday= strtotime(date("Y-m-d",time()-60*60*24*7));
//
//        //今日成交
//        $todayDate = Order::where('status',Order::FINISH)->where('updated_at','>',$today);
//
//        //昨日成交
//        $yesterdayDate = Order::where('status',Order::FINISH)->where('updated_at','>',$yesterday)->where('updated_at','<',$today);


        return view('admin::orders.chart',compact('header','description'));
    }

    /**
     * @permission 总交易量走势数据
     * @return array
     */
    public function General_trend(){

        $show_shop_id = checkShopper();

        if($show_shop_id) {
            $orders = Order::where('status', 'in', [Order::WAIT_COMMENT, Order::FINISH])->where('shop_id', $show_shop_id)->get();
            $data = [];
            foreach ($orders as $key => $arr) {
                $day = strtotime(date("Y-m-d", strtotime($arr->updated_at->toDateTimeString())));
                $data[] = $day;
            }
            $data = array_count_values($data); //统计 '时间戳'=>'交易笔数'  eg: '1531843200' => 3,
            ksort($data); //按键名排序

            reset($data);   //指针指向第一个
            $begin = key($data);
            end($data);     //指针指向最后一个
            $end = strtotime(date("Y-m-d", time()));

            $fill_arr = []; //制作填充数组
            for ($i = $begin; $i <= $end; $i += 24 * 60 * 60) {
                $fill_arr[$i] = 0;
            }

            $res = [];  //制作展示数据 格式：['时间戳','交易笔数'] （时间戳单位毫秒）
            foreach ($fill_arr as $key => $val) {
                if (array_key_exists($key, $data)) {
                    $res[] = [$key * 1000, $data[$key]];
                } else {
                    $res[] = [$key * 1000, $val];
                }
            }
            return $res;
        }else return $res =[];


    }
}