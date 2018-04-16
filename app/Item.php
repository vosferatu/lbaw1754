<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The card this item belongs to.
   */
  public function card() {
    return $this->belongsTo('app\Card');
  }
}
