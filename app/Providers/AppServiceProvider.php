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
        view()->composer(['layouts.app'], function ($view) {

            $sideMenu=[
                // 'dashboard' => [
                //             'icon' => 'fas fa-users',
                //             'route_name' => 'dashboard',
                //             'permissions' => [],
                //             'title' => 'Dashboard'
                //         ],
                'administration' => [
                            'icon' => 'fas fa-users',
                            'title' => 'Administration',
                            'permissions' => ['users-view','roles-view'],
                            'sub_menu' => [
                                'users' => [
                                    'route_name' => 'administration.users.index',
                                    'permissions' => ['users-view'],
                                    'title' => 'User Management'
                                ],
                                'roles' => [
                                    'route_name' => 'administration.roles.index',
                                    'permissions' => ['roles-view'],
                                    'title' => 'Role Management'
                                ],
                            ] 
                        ],
            ];

           $view->with('sideMenu', $sideMenu);
        });
    }
}
