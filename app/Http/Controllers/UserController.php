<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class UserController extends Controller
{
    public function index()
    {
        return view('user-management.index');
    }
}
