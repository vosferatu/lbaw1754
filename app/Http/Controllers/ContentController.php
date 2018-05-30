<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Post;
use App\Content;
use App\Comment;
use App\Upvote;
use App\Downvote;
use App\ContentReport;
use App\Save;
use App\Tag;

use Carbon\Carbon;


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

   
    $posts = Post::all()->where('published',1);
    $tags = Tag::all();

    return view('posts.index', compact('posts','tags'));
  }

  public function indexPostsByDate()
  {
    //if (!Auth::check()) return redirect('/login');
    //$this->authorize('list', Card::class);
    //$cards = Auth::user()->cards()->orderBy('id')->get();

   
    $posts = Post::orderBy('published_date','asc')->where('published',1)->get();
    $tags = Tag::all();

    return view('posts.index', compact('posts','tags'));
  }

  public function indexPostsByTag(Tag $tag)
  {
    $tags = Tag::all();

    $posts = $tag->posts()->where('published',1)->get();

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
      $type = "show";

      return view('posts.show', compact('post','tags','type'));
    }
    
  public function showPostForm()
  {

    $tags = Tag::all();
    $type = "create";

    return view('posts.show',compact('tags','type'));
  }

  public function createPost(Request $request){

    $this->validate(request(), [
      'title' => 'required',
      'text' => 'required',
      'tags' => 'required'
  ]);


    $content = Content::create([
      'text' => $request->input('text'),
      'created' => Carbon::now('Europe/Lisbon')
    ]);

    $slug = str_slug($request->input('title'),"-") . "-" . $content->id;
    
    $this->authorize('createContent', $content);


    $post = Post::create([
      'id' => $content->id,
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'slug' => $slug,
      'comments_count' => 0,
      'views' => 0,
      'authors' => 1,
      'published' => $request->input('published'),
      'published_date' => $content->created
    ]);


    $tags_string = $request->input('tags');
    $tags_names = explode(",", $tags_string);

    $tags = array();

    foreach ($tags_names as $tag){
      $tagModel = Tag::where('name', $tag)->first();
      $post->tags()->attach($tagModel->id);
    }


    $post->users()->attach(Auth::user()->id, ['ready'=> 1, 'approval_date' => Carbon::now('Europe/Lisbon')]);


    return response()->json(['published'=> $request->input('published'), 'slug'=>$post->slug, 'user_id'=> Auth::user()->id]);
  }


  public function addComment(Post $post){


      $content = Content::create([
        "text" => request('text'),
        "created" => Carbon::now('Europe/Lisbon')
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
    $var = $content->saves->where('id_user', Auth::user()->id)->first();
    
    if($var){
      $var->delete();
      return;
    }

    $var = $content->saves->where('id_user', Auth::user()->id)->first();
    
    if($var){
      $var->delete();
      return;
    }

    Save::create([
      'id_content' => $content->id,
      'id_user' => Auth::user()->id,
    ]);

    return $content;
  }

  /*************************************************************** */

  public function putupvote(Content $content)
  {
    $upvote = $content->upvotes->where('id_user', Auth::user()->id)->first();

    $downvote = $content->downvotes->where('id_user', Auth::user()->id)->first();

    if($downvote){
      $this->upvote($content);
      $downvote->delete();
    } else {
            if(!$downvote && !$upvote){
              $this->upvote($content);
          } else if ($upvote && !$downvote) {
            $upvote->delete();
          }
    }

    $num = Content::find($content->id)->votes;

    return response()->json(['votes'=>$num]);
  }
  
  /********************************************************** */

  public function putdownvote(Content $content)
  {
    $downvote = $content->downvotes->where('id_user', Auth::user()->id)->first();

    $upvote = $content->upvotes->where('id_user', Auth::user()->id)->first();

    if($upvote){
      $this->downvote($content);
      $upvote->delete();
    } else {
        if(!$downvote && !$upvote){
              $this->downvote($content);
          } else if ($downvote && !$upvote) {
              $downvote->delete();
          }
      }
      
    $num = Content::find($content->id)->votes;

    return response()->json(['votes'=>$num]);
  }
  
  public function searchByName(Request $request) {
    $searchText = $request->input('text');
    
    $hi_posts = DB::select("SELECT * from news_post
     WHERE textsearchable_name_col @@ to_tsquery('english',?)
     ORDER BY title DESC LIMIT 20",[$searchText]);

    $contents = DB::select("SELECT * from content
    WHERE textsearchable_name_col @@ to_tsquery('english',?)
    ORDER BY text DESC LIMIT 20",[$searchText]);

    $posts = Post::hydrate($hi_posts);

    $contents = Content::hydrate($contents);

    foreach ( $contents as $content){
        $var = $content->posts()->first();

        $posts->push($var);
    }


    $tags = Tag::all();
    return view('posts.index', compact('posts','tags'));    }

}
