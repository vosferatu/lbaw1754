<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upvotes';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;

     protected $fillable = ['id_content', 'id_user'];


    /**
     * Get the content behind upvote.
     */
     public function content()
    {
        return $this->belongsTo('App\Content','id_content');
    }

     /**
     * Get the user behind upvote.
     */

    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }
}
