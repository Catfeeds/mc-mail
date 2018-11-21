<?php
use Tanmo\Admin\Facades\Admin;

function mlog($txtname,$data){
    $now = date("Y-m-d H:i:s",time());
    file_put_contents($txtname.".txt",var_export($now,1)."\r\n",FILE_APPEND);
    file_put_contents($txtname.".txt",var_export($data,1)."\r\n",FILE_APPEND);
    file_put_contents($txtname.".txt","================================"."\r\n",FILE_APPEND);
}

function getIp() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
}

function getShowShopId(){
    $ip = getIp();
    $shop_id = \Illuminate\Support\Facades\Redis::get($ip."show_shop_id");
    return $shop_id;
}

function checkShopper(){

    if(\Tanmo\Admin\Facades\Admin::user()->isAdmin()){
        $show_shop_id = getShowShopId();
    }else{
        if($show_shop = \App\Models\ShopAdmin::find(\Tanmo\Admin\Facades\Admin::user()->id)->shop) {
            $show_shop_id = $show_shop->id;
        }else $show_shop_id = 0;
    }

    return $show_shop_id;
}
