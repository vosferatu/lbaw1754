<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name', 'email', 'password', 'country', 'introduction', 'photo', 'followers'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The cards this user owns.
     
    * public function cards() {
     * return $this->hasMany('App\Card');
    *}
    */

     /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

     /**
     * Get the upvotes of user.
     */
    public function upvotes()
    {
        return $this->hasMany('App\Upvote','id_user');
    }

    /**
     * Get the reports of user.
     */
    public function reports()
    { 
        return $this->hasMany('App\Reports','id_user');
    }

        /**
     * Get the saves of user.
     */
    public function saves()
    {
        return $this->hasMany('App\Save','id_user');
    }

      /**
     * The posts that belong to the user.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'news_creation', 'id_user', 'id_news')->as('creation')->withPivot('ready', 'approval_date');
    }



}
