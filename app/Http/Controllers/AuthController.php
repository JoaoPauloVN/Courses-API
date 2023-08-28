<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register() {
        return Inertia::render("Auth/Register");
    }
    
    public function login() {
        return Inertia::render("Auth/Login");
    }
}
