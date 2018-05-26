<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_post';

    protected $fillable = ['title', 'article', 'tags'];

    /**
     * Get the content behind post.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id');
    }
    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

     /**
     * Return if the post is published.
     *
     * @return Response
     */
    public function isPublished()
    {
        
    }

     /**
     * Return if the post is unpublished.
     *
     * @return Response
     */
    public function isUnpublished()
    {
        
    }

    /**
     * Publishes a post.
     *
     * @return Response
     */
    public function publish()
    {
        
    }




}
