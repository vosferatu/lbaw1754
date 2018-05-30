<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

use App\User;
use App\Tag;



class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    public function show(User $user)
    {   
        return view('users.show', compact('user'));
    }
    
    public function getUserDrafts(User $user)
    {   
        $tags = Tag::all();

        $posts = $user->posts()->where('published',0)->get();
    
        return view('posts.index', compact('posts','tags'));
    }

    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

      public function updateProfile(Request $request, User $user)
    { 
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:4',
            'introduction' => 'string|max:255',
        ]);


        $user->name = request('name');
        $user->country = request('country');
        $user->introduction = request('introduction');

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateEmail(User $user)
    { 
        $this->validate(request(), [
            'email' => 'required|email|unique:users',
        ]);
        
        $user->email = request('email');

        $user->save();

        return back()->with('success', 'E-mail updated successfully.');
    }

    public function updatePassword(User $user)
    { 
        $this->validate(request(), [
            'password' => 'required|min:6|confirmed'
        ]);
        
        $user->password = bcrypt(request('password'));

        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function delete(Request $request, $user)
    {

     //$this->authorize('delete', $user);
    
      $users = Auth::user($user);
      $users->delete();

      return redirect('/');
    }

    public function searchByUsername($username){
        $user = User::where('username', $username)->first();
    
        if($user == null)
        return response()->json(['user'=>'dontExist']); 
        else if($user->id == Auth::user()->id)
        return response()->json(['user'=>'owner']); 
        else
        return response()->json(['user'=>$user]); 
    }
}
