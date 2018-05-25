<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
     /**
   * Shows all posts.
   *
   * @return Response
   */
  public function list()
  {
    //if (!Auth::check()) return redirect('/login');
    //$this->authorize('list', Card::class);
    //$cards = Auth::user()->cards()->orderBy('id')->get();

    return view('posts.list');
  }

  public function showPostForm()
  {
    return view('posts.create');
  }

  public function create()
  {
    //dd(request()->all());

    Post::create([

      'title' => request('title'),

      'article' => request('article'),

      'tags' => request('tags'),

    ]);


    return redirect('/');

  }
}
