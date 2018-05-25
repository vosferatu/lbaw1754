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
}
