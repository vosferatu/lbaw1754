<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderator extends Model{


	public $timestamps  = false;

	protected $fillable = [
        'id','started'];

	protected $table = 'moderator';
}
