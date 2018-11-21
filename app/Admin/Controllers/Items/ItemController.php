<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/13
 * Time: 15:35
 * Function:
 */

namespace App\Admin\Controllers\Items;


use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemCover;
use App\Models\ItemRecommend;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
use App\Models\Shop;
use App\Models\ShopAdmin;
use Tanmo\Admin\Facades\Admin;

/**
 * @module 商品管理
 *
 * Class ItemController
 * @package App\Admin\Controllers\Items
 */
class ItemController extends Controller
{
    /**
     * @permission 商品列表
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
            $searcher->equal('id');
            $searcher->like('title');
        });


        $items = (new Item())->search($searcher)->orderBy('sort', 'desc')->orderBy('order', 'asc')->orderBy('created_at', 'desc')->where('shop_id','=',$show_shop_id)->paginate(10);
        $recommends = ItemRecommend::pluck('item_id')->toArray();
        return view('admin::items.items', compact('items','recommends','header'));
    }

    /**
     * @permission 新增商品-页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tops = (new ItemCategory())->where('parent_id','=',0)->where('platform_id','=',1)->get();
        return view('admin::items.item-create', compact('tops'));
    }

    /**
     * @permission 新增商品
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
            $item = new Item();
            $item->category_id = $request->get('category_id');
            $item->sn = $request->get('sn');
            $item->sort = $request->get('sort');
            $item->title = $request->get('title');
            $item->price = $request->get('price');
            $item->original_price = $request->get('original_price');
            $item->freight = $request->get('freight');
            $item->stock = $request->get('stock');
            $item->details = $request->get('details');
            $item->status = $request->get('status');
            $item->shop_id = $show_shop_id;
            $item->save();

            ///
            foreach ($request->file('covers') as $file) {
                /**
                 * @var $file UploadedFile
                 */
                $path = $file->store('covers', 'public');
                $cover = new ItemCover(['path' => $path]);
                $item->covers()->save($cover);
            }
        }else{
            $header = "暂无店铺";
        }



        return redirect()->route('admin::items.index','header');
    }

    /**
     * @permission 修改商品-页面
     *
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$item)) {

            $tops = (new ItemCategory())->where('parent_id', '=', 0)->where('platform_id', '=', 1)->get();
            $categorys = (new ItemCategory())->where('parent_id', '=', $item->category->parent_id)->where('platform_id', '=', 1)->get();
            return view('admin::items.item-edit', compact('item', 'tops', 'categorys'));

        }
        return response()->json(['status' => 0, 'message' => '您无权操作其他商铺商品']);
    }

    /**
     * @permission 修改商品
     *
     * @param Item $item
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Item $item, Request $request)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$item)) {
            $item->title = $request->get('title');
            $item->sn = $request->get('sn');
            $item->sort = $request->get('sort');
            $item->category_id = $request->get('category_id');
            $item->price = $request->get('price');
            $item->original_price = $request->get('original_price');
            $item->freight = $request->get('freight');
            $item->stock = $request->get('stock');
            $item->details = $request->get('details');
            $item->status = $request->get('status');
            $item->save();
            if ($request->file('covers')) {
                foreach ($request->file('covers') as $file) {
                    /**
                     * @var $file UploadedFile
                     */
                    $path = $file->store('covers', 'public');
                    $cover = new ItemCover(['path' => $path]);
                    $item->covers()->save($cover);
                }
            }
            return redirect()->route('admin::items.index');
        }
        return response()->json(['status' => 0, 'message' => '您无权操作其他商铺商品']);
    }

    /**
     * @permission 删除商品
     *
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item)
    {
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$item)) {
            $item->delete();

          return response()->json(['status' => 1, 'message' => '成功']);
       }
        return response()->json(['status' => 0, 'message' => '您无权操作其他商铺商品']);
    }

    /**
     * @permission 库存预警
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function warning()
    {
        if (request()->method() == 'PUT'&& Admin::user()->isAdmin()) {

            $count = request()->get('warning_count');

            edit_env(['ITEMS_EARLY_WARNING' => (int)$count]);

            return response()->json(['status' => 1, 'message' => '成功']);
        }
        if ($show_shop_id = checkShopper()) {
            $items = Item::warning()->orderBy('sort', 'desc')->orderBy('order', 'asc')->orderBy('created_at', 'desc')->where('shop_id','=',$show_shop_id)->paginate(10);
        }else{
            $header = "暂无店铺";
        }

        return view('admin::items.items-warning', compact('items','header'));
    }

    /**
     * @permission 回收站
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recycle(){
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }
        $items = (new Item())->orderBy('sort', 'desc')->orderBy('order', 'asc')->orderBy('created_at', 'desc')->where('shop_id','=',$show_shop_id)->onlyTrashed()->paginate(10);
        return view('admin::items.items-recycle', compact('items','header'));
    }

    public function reduction($item){
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }
        $item = Item::withTrashed()->where('shop_id','=',$show_shop_id)->find($item);
        $item->restore();
        return redirect()->route('admin::items.recycle','header');
    }

    /**
     * @permission  出售中
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sell(){
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('id');
            $searcher->like('title');
        });

        $items = (new Item())->search($searcher)->orderBy('sort', 'desc')->orderBy('order', 'asc')->orderBy('created_at', 'desc')->where('status','=',1)->where('shop_id','=',$show_shop_id)->paginate(10);
        $recommends = ItemRecommend::pluck('item_id')->toArray();
        return view('admin::items.items-sell', compact('items','recommends','header'));
    }

    /**
     * @permission 仓库中
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stock(){
        if ($show_shop_id = checkShopper()){
            $header = Shop::find($show_shop_id)->title;
        }else{
            $header = "暂无店铺";
        }
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('id');
            $searcher->like('title');
        });

        $items = (new Item())->search($searcher)->orderBy('sort', 'desc')->orderBy('order', 'asc')->orderBy('created_at', 'desc')->where('status','=',0)->where('shop_id','=',$show_shop_id)->paginate(10);
        $recommends = ItemRecommend::pluck('item_id')->toArray();
        return view('admin::items.items-stock', compact('items','recommends','header'));
    }

    public function change(Item $item, Request $request){
        if(ShopAdmin::find(Admin::user()->id)->can('adminShop',$item)) {
            $item->price = $request->get('price');
            $item->save();
            return response()->json(['message' => '修改成功', 'status' => '1']);
        }
        return response()->json(['status' => 0, 'message' => '您无权操作其他商铺商品']);
    }
}