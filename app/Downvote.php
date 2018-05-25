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
}
