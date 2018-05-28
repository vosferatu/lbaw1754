<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_report';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;

     protected $fillable = ['id_content', 'id_user','reason'];


        /**
     * Get the content behind report.
     */
    public function content()
    {
        return $this->belongsTo('App\Content','id_content');
    }

     /**
     * Get the user behind report.
     */

    public function user()
    {
        return $this->belongsTo('App\User','id_user');
    }
}
