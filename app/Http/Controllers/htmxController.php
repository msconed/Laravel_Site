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

    public function modal_new_topic(Request $request) {
        return view('modals.new_topic',['categoryName' => $request->input('categoryName'), 'SubCategoryName' => $request->input('SubCategoryName'), 'path2' => $request->input('path2')]);
    }
}