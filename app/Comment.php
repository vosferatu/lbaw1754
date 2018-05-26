<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Content
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';


     /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');

    }

      /**
     * Get the content behind post.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id');
    }
}
