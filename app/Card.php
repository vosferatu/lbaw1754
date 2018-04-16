<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The user this card belongs to
   */
  public function user() {
    return $this->belongsTo('app\User');
  }

  /**
   * Items inside this card
   */
  public function items() {
    return $this->hasMany('app\Item');
  }
}
