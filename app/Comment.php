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
        return $this->belongsTo('App\Post','parent_news');
    }

      /**
     * Get the content behind comment.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id');
    }

          /**
     * Get the user behind comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
