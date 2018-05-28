<?php

namespace App\Policies;

use App\User;
use App\Content;
use App\Comment;
use App\Post;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;


class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function createContent(User $user)
    {
      // Any user can create  new content
      return Auth::check();
    }
}
