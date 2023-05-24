<?php

namespace App\Providers;

use App\Models\MasterUsers;
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

        //
        Gate::define('admin', function (MasterUsers $user) {
            return $user->roles_id === 1 || $user->roles_id === "1";
        });
        Gate::define('pengajar', function (MasterUsers $user) {
            return $user->roles_id === 2 || $user->roles_id === "2";
        });
        Gate::define('pengurus', function (MasterUsers $user) {
            return $user->roles_id === 3 || $user->roles_id === "3";
        });
        Gate::define('adminpengajar', function (MasterUsers $user) {
            $allowedRoles = [1, 2, "1", "2"];
            return in_array($user->roles_id, $allowedRoles);
        });
        Gate::define('adminpengajarpengurus', function (MasterUsers $user) {
            $allowedRoles = [1, 2, 3, "1", "2", "3"];
            return in_array($user->roles_id, $allowedRoles);
        });
        Gate::define('adminpengurus', function (MasterUsers $user) {
            $allowedRoles = [1, 3, "1", "3"];
            return in_array($user->roles_id, $allowedRoles);
        });

        Gate::define('allRoles', function (MasterUsers $user) {
            $allowedRoles = [1, 2, 3, "1", "2", "3"];
            return in_array($user->roles_id, $allowedRoles);
        });
    }
}
