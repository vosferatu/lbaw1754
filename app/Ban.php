<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model{


	public $timestamps  = false;

	protected $fillable = [
        'id'];

	protected $table = 'banned';
}
