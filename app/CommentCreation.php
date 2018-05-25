<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentCreation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment_creation';

    // Don't add create and update timestamps in database.
  public $timestamps  = false;
}
