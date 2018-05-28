<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];


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

    /**
     * Get the upvotes of content.
     */
    public function upvotes()
    {
        return $this->hasMany('App\Upvote','id_content');
    }

    /**
     * Get the count of upvotes
     */
    public function upvotesCount()
    {
        return $this->upvotes()->count();
    }

      /**
     * Get the downvotes of content.
     */
    public function downvotes()
    {
        return $this->hasMany('App\Downvote','id_content');
    }

    /**
     * Get the count of downvotes.
     */
    public function downvotesCount()
    {
        return $this->downvotes()->count();
    }


/**
     * Get the upvotes of content.
     */
    public function reports()
    {
        return $this->hasMany('App\Report','id_content');
    }

    /**
     * Get the saves of content.
     */
    public function saves()
    {
        return $this->hasMany('App\Save','id_content');
    }
    

    


}
