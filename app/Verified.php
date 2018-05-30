<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Verified extends Model{


	public $timestamps  = false;

	protected $fillable = [
        'id','status', 'verified', 'description'];

	protected $table = 'verified';
}
