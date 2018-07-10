<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
	 * show the home page
	 * @return view
	 */
    public function show()
    {
    	return view('home');
    }

    /**
     * Show about page
     * @return view
     */
    public function about()
    {
    	return view('about');
    }
}
