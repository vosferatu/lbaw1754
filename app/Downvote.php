<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downvote extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'downvotes';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;

     protected $fillable = ['id_content', 'id_user'];


      /**
     * Get the content behind downvote.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id_content');
    }

     /**
     * Get the user behind downvote.
     */

    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }
}
