<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Permission;
use App\Policies\BillPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Bill::class => BillPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = Permission::with('roles')->get();

        $permissions->each(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        });

        //Blade directives
        Blade::if('hasRoleOnModel', function ($model) {
            return auth()->check() && auth()->user()->hasRoleOnModel($model);
        });
    }
}
