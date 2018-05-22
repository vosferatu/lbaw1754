<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Content
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_post';


    /** 
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
