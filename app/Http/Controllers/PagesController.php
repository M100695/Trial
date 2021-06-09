<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title = "Welcome to my blog";
      //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
        //same output yung "compact and with" magkaiba lang syntax //trying some syntax
    
    }

    public function about()
    {
        $title = "This is for about pages";
        //return view('pages.about');
        return view('pages.about')->with('title', $title);
    
    }
    /*
    //it can be edit to services or contact info page pero ngayon for objective muna.
    //d kelangan
    public function objective()
    {
        $data = array
        (
            'title' => 'This is for objective pages'
            
        );
        return view('pages.objective')->with($data);
        
    
    }
    */
}
