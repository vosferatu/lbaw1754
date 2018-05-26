<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * Get the posts of content table.
     */
    public function posts()
    {
        return $this->hasMany('App\Post','id');
    }

      /**
     * Get the comments of content table.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment','id');
    }


}
