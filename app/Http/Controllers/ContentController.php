<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Content;

class ContentController extends Controller
{
     /**
   * Shows all posts.
   *
   * @return Response
   */
  public function indexPosts()
  {
    //if (!Auth::check()) return redirect('/login');
    //$this->authorize('list', Card::class);
    //$cards = Auth::user()->cards()->orderBy('id')->get();

   
    $posts = Post::all();

    return view('posts.index', compact('posts'));
  }


   /**
     * Show the specific post
     *
     * @param  Post  $post
     * @return Response
     */
    public function showPost($slug)
    {
      $post = Post::find($slug);

      return view('posts.show', compact('post'));
    }
    
  public function showPostForm()
  {
    return view('posts.create');
  }

  public function createPost()
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
