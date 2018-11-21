<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\User;
use App\Policies\ItemPolicy;
use App\Models\UserLevel;
use App\Policies\OrderPolicy;
use App\Policies\OrderRefundPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserLevelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Item::class => ItemPolicy::class,
        OrderRefund::class => OrderRefundPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
