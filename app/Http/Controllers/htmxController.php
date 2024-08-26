<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class htmxController extends Controller
{
    public function modal_auth(Request $request) {
        return view('modals.auth',[]);
    }

    public function modal_signup(Request $request) {
        return view('modals.signup',[]);
    }
}