<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Brings in the User to use
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated user id
        $user_id = auth()->user()->id;
        // Find the user with the authenticated id
        $user = User::find($user_id);
        // Pass along to the view the posts of the user
        return view('dashboard')->with('posts', $user->posts);
    }
}
