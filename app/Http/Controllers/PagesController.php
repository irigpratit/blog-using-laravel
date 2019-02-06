<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title="Welcome to Pratit Raj Giri's Blog";
        return view('pages.index')->with('title',$title);
    }

    public function about(){
        $title="About Me";
        return view('pages.about')->with('title',$title);
    }

    public function services(){
        $data=array(
            'title'=>'Services',
            'services'=>['Web Design','Programming','Laravel Tutorial']
        );
        return view('pages.services')->with($data);
    }
}