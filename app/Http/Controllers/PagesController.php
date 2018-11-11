<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // method for the site index or homepage
    // displays index file in pages folder

    public function index () {
        return view('pages.index');
    }

    // method for the site about page
    // displays about file in pages folder

    public function about () {
        return view('pages.about');
    }

    // method for the site services page
    // displays services file in pages folder

    public function services () {
        return view('pages.services');
    }
}
