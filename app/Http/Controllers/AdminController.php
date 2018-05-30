<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Post;
use App\Content;
use App\Comment;
use App\Upvote;
use App\Downvote;
use App\ContentReport;
use App\Save;
use App\Tag;
use App\Admin;
use App\User;
use Carbon\Carbon;

class AdminController extends Controller
{

	public function verifyUser(){
	
		if(!Auth::check()){
			return null;
		}
	
		return Admin::find(Auth::user()->id);
	}

	public function getRecentUsers(){
		$timeNow = ((string)now()->subDays(10)).'+00';
		return User::where('registered', '>=', $timeNow)
			     ->orderBy('registered','DESC')
			     ->get();
	}
	public function getUsers(){
		$users = array();
		$pendingUsers = array();

		$allUsers = User::all();
		foreach ($allUsers as $user){
			$userID = $user->id;
			#Status Order: Inactive, Banned, Kicked, Admin, Mod, Verified

			if(DB::table('inactive')->find($userID) != null){
				$Status = 'Inactive';
			}else
			if(DB::table('banned')->find($userID) != null){
				$Status = 'Permanently Banned';
			}else
			if(DB::table('kicked')->find($userID) != null){
				$Status = 'Temporarily Banned';
			}else
			if(DB::table('administrator')->find($userID) != null){
				$Status = 'Administrator';
			}else
			if(DB::table('moderator')->find($userID) != null){
				$Status = 'Moderator';
			}else
			if(($VeriSt = DB::table('verified')->find($userID)) != null){
				if($VeriSt->status=='Pending'){
					$Status = 'Pending Verified Account Request';
					array_push($pendingUsers, array($user->id,
									$user->username,
									(new Carbon($user->registered))->format('d/m/y h:m'),
									$VeriSt->description));
				}
				else
					$Status = 'Verified Account';
			}else
				$Status = 'Normal';

			array_push($users, array($user->id,
						 $user->username,
						 (new Carbon($user->registered))->format('d/m/y h:m'),
						 $Status));
		}
		return array($users, $pendingUsers);
	}
	public function getPosts(){
	}
	public function getReports(){
	}

	public function showPage(){
		if(null==$this->verifyUser()){
			return view('errors.404');
		}
		$users = $this->getRecentUsers();
		return view('admin.admin', compact('users'));
	}
	   
	public function showUsersPage(){
		if(null==$this->verifyUser()){
			return view('errors.404');
		}
		$arrUsers = $this->getUsers();
		$pendingUsers = $arrUsers[1];
		$users = $arrUsers[0];
		return view('admin.admin-users')->with(compact('pendingUsers', 'users'));
	}

	public function showPostsPage(){
		if(null==$this->verifyUser()){
			return view('errors.404');
		}
		$this->getPosts();
		return view('admin.admin-posts');
	}
	   
	public function showReportsPage(){
		if(null==$this->verifyUser()){
			return view('errors.404');
		}
		$this->getReports();
		return view('admin.admin-reports');
	}
}
