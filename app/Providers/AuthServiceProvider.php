<?php

namespace App\Providers;

use App\Providers\Auth\MyEloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * @param \Illuminate\Support\Facades\Gate  $gate
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);


        //进行拦截注入，my_eloquent 自定义需要与配置文件对应。
        Auth::provider('my_eloquent', function ($app, $config) {
            return new MyEloquentUserProvider($this->app['hash'], $config['model']);
        });
    }
}
