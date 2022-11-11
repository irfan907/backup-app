<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.master'], function ($view) {

            $sideMenu=[
                'dashboard' => [
                            'icon' => 'fas fa-users',
                            'route_name' => 'dashboard',
                            'permission' => 'auth',
                            'title' => 'Dashboard'
                        ],
                'administration' => [
                            'icon' => 'fas fa-users',
                            'title' => 'Administration',
                            'sub_menu' => [
                                'users' => [
                                    'route_name' => 'administration.users.index',
                                    'permission' => 'admin',
                                    'title' => 'User Management'
                                ],
                                'roles' => [
                                    'route_name' => 'administration.roles.index',
                                    'permission' => 'admin',
                                    'title' => 'Role Management'
                                ],
                            ] 
                        ],
            ];

           $view->with('sideMenu', $sideMenu);
        });
    }
}
