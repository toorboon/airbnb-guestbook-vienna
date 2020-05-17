<?php

namespace App\Http\Controllers;

use App\Accommodation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // fetch magicLinks?
        // fetch 42???

        if($request->filled('search')) {

            $users = User::search($request->get('search'))->get();
            $accommodations = Accommodation::search($request->get('search'))->get();
            $request->flash();
        } else {
            $users = User::all();
            $accommodations = Accommodation::all();
        }

        return view('admin.dashboard')
            ->with('users', $users)
            ->with('accommodations', $accommodations);
    }

}
