<?php

namespace App\Http\Controllers;
use Illuminate\View\View; 

use Illuminate\Http\Request;

class LoginMaliciousController extends Controller
{
    public function index(): View
    {
        return view('auth.loginmalicious');
    }
}
