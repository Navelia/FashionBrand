<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('customer', function($user){
            return ($user->role=='customer'? Response::allow():Response::deny('Anda tidak boleh mengakses halaman ini!'));
        });
        Gate::define('owner', function($user){
            return ($user->role=='owner'? Response::allow():Response::deny('Anda tidak boleh mengakses halaman ini!'));
        });
        Gate::define('staff', function($user){
            return (($user->role=='owner' || $user->role=='staff')? Response::allow():Response::deny('Anda tidak boleh mengakses halaman ini!'));
        });
    }
}
