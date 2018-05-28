<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'saves';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;

     protected $fillable = ['id_content', 'id_user'];

           /**
     * Get the content behind save.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id_content');
    }

     /**
     * Get the user behind save.
     */

    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }

}
