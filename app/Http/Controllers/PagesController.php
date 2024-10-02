<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //any function inside of class is also calle da methos
    public function index(){
        $message = 'Welcome to MySpace';
        // return view('pages.index', compact('title')); //one way to do this
        return view('pages.index')->with('message', $message); //the second  way
    }

    public function about(){
        return view('pages.about');
    }

    public function services(){
        $data = array(
            'title' => 'Services',
            'services'=>['web design', 'programming', 'design']
        );
        return view('pages.services')->with($data);
    }
}
