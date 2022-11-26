<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function userManagement()
    {
        $this->authorize('users-view');
        return view('user-management.index');
    }

    public function roleManagement()
    {
        $this->authorize('roles-view');
        return view('role-management.index');
    }

    public function fileMangement()
    {
        return view('filemanager');
    }
}
