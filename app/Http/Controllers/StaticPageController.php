<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function showAbout(){
      return view('pages.about');
    }

    public function showContentPolicy(){
      return view('pages.contentpolicy');
    }

    public function showContact(){
      return view('pages.contact');
    }

    public function showFAQ(){
      return view('pages.faq');
    }




}
