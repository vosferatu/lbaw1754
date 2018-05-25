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
}
