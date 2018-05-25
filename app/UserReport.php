<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_report';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;
}
