<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\UserLevel;

class UserLevelUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->load('orders');
        $firstDay = date('Y-m-d',strtotime("-1 month"));
        $lastDay = date('Y-m-d',strtotime("-1 day"));
        $dateNumber = intval(date('d',strtotime("-1 day")));

        $userLevels = UserLevel::orderBy('level','desc')->get();

        $orders = $this->user->orders()->whereBetween('created_at',[$firstDay,$lastDay])->with('items.item.category')->get();
        foreach($userLevels as $userLevel) {
            $brands_money = 0 ;
            $date_num = 0;

            for ($i=0;$i<$dateNumber;$i++) {
                $date = date('Y-m-d',strtotime("-1 month +$i day"));
                $price = $this->user->orders()->whereDate('created_at',$date)->sum('price');
                if($price >= $userLevel->date_money) {
                    $date_num++;
                }
            }
            if($date_num >= $userLevel->date_num) {
                if(!$userLevel->brands){
                    $this->user->level = $userLevel->level;
                    $this->user->save();
                    break;
                }
                else {
                    foreach($orders as $order) {
                        foreach($order->items as $item) {
                            if(in_array($item->item->category->id,$userLevel->brands)) {
                                $brands_money += $item->price*$item->count;
                            }
                        }
                    }
                    if($brands_money >= $userLevel->brands_money) {
                        $this->user->level = $userLevel->level;
                        $this->user->save();
                        break;
                    }
                }
            }
        }
    }
}
