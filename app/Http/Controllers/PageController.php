<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function roleManagement()
    {
        return view('role-management.index');
    }
}
