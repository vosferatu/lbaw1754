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
  public function index()
  {
    //if (!Auth::check()) return redirect('/login');
    //$this->authorize('list', Card::class);
    //$cards = Auth::user()->cards()->orderBy('id')->get();

    $posts = Post::all();

    return view('posts.index', compact('posts'));
  }

<<<<<<< HEAD

   /**
     * Show the specific post
     *
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
=======
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
>>>>>>> 640972e7647f09ffe12174f323d2821c5a606898
}
