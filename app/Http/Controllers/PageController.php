<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
    	return view('pages.index');
    }

    public function about(){
    	return view('pages.about');
    }

    public function legal(){
        $adminRole = Role::where('name', 'Admin')->pluck('id');
        $responsibleAdmin = User::where('role_id', $adminRole)->first();

        return view('pages.legal')
            ->with('responsibleAdmin', $responsibleAdmin);
    }
}
