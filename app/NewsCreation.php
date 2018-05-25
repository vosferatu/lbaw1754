<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCreation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_creation';

     // Don't add create and update timestamps in database.
     public $timestamps  = false;
}
