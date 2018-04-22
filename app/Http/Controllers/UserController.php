<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;


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

    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

      public function update(User $user)
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

        return back();
    }
}
