<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;

      /**
     * The posts that belong to the tag.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post','tags_post','id_tag','id_post');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
 