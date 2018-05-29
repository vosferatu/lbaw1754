<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Post;
use App\Content;
use App\Comment;
use App\Upvote;
use App\Downvote;
use App\ContentReport;
use App\Save;
use App\Tag;


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
    $tags = Tag::all();

    return view('posts.index', compact('posts','tags'));
  }

  public function indexPostsByDate()
  {
    //if (!Auth::check()) return redirect('/login');
    //$this->authorize('list', Card::class);
    //$cards = Auth::user()->cards()->orderBy('id')->get();

   
    $posts = Post::orderBy('published_date','desc')->get();
    $tags = Tag::all();

    return view('posts.index', compact('posts','tags'));
  }

  public function indexPostsByTag(Tag $tag)
  {
    $tags = Tag::all();

    $posts = $tag->posts()->get();


    return view('posts.index', compact('posts','tags'));
  }


   /**
     * Show the specific post
     *
     * @param  Post  $post
     * @return Response
     */
    public function showPost(Post $post)
    {
      $tags = Tag::all();

      return view('posts.show', compact('post','tags'));
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

  public function addComment(Post $post){


      $content = Content::create([
        "text" => request('text'),
      ]);

      $this->authorize('createContent', $content);

      
      Comment::create([
        'id' => $content->id,
        'user_id' => Auth::user()->id,
        'parent_comment' => 0,
        'parent_news' => $post->id
      ]);

      return back();
  }


  public function upvote(Content $content)
  {

    Upvote::create([
      'id_content' => $content->id,
      'id_user' => Auth::user()->id,
    ]);

    return $content;
  }

  public function downvote(Content $content)
  {

    Downvote::create([
      'id_content' => $content->id,
      'id_user' => Auth::user()->id,
    ]);

    return $content;
  }


  public function report(Content $content, Request $request)
  {

    $this->validate(request(), [
      'reason' => 'required',
  ]);
  

    $report = ContentReport::create([
      'reason' => $request->input('reason'),
      'id_content' => $content->id,
      'id_user' => Auth::user()->id,
    ]);

    $request->session()->flash('message', 'The report was sent.');
    $request->session()->flash('message-type', 'success');

    return response()->json(['status'=>'Success']);
  }

  public function save(Content $content)
  {

    Save::create([
      'id_content' => $content->id,
      'id_user' => Auth::user()->id,
    ]);

    return $content;
  }

  /*************************************************************** */

  public function getupvotesbyuser(Content $content)
  {
    $upvote = $content->upvotes->where('id_user', Auth::user()->id)->first();

    $downvote = $content->downvotes->where('id_user', Auth::user()->id)->first();

    $res = 'Empty';

    if($downvote){
      $downvote->delete();
      $res = 'Double';
    }

    if(!$upvote)//if(empty($upvote->items))
      return response()->json(['state'=>$res]);
    return response()->json(['state'=>'Full']);
  }
  
  public function deleteupvote(Content $content)
  {
    $upvote = $content->upvotes->where('id_user', Auth::user()->id)->first();
    
    if($upvote)
      $upvote->delete();

    //ddump($upvote);

    return response()->json(['status'=>'Success']);
  }

  /********************************************************** */

  public function getdownvotesbyuser(Content $content)
  {
    $downvote = $content->downvotes->where('id_user', Auth::user()->id)->first();

    $upvote = $content->upvotes->where('id_user', Auth::user()->id)->first();

    //print_r($upvote);

    $res = 'Empty';

    if($upvote){
      $upvote->delete();
      $res = 'Double';
    }

    if(!$downvote)//if(empty($downvote->items))
      return response()->json(['state'=>$res]);
    return response()->json(['state'=>'Full']);
  }
  
  public function deletedownvote(Content $content)
  {
    $downvote = $content->downvotes->where('id_user', Auth::user()->id)->first();

    if($downvote)
      $downvote->delete();

    return response()->json(['status'=>'Success']);
  }
}
