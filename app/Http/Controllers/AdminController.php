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
use App\Verified;
use Carbon\Carbon;

class AdminController extends Controller
{

	public function checkUser(){
	
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
			$userVeri = 'Not Verified';
			#Status Order: Inactive, Banned, Kicked, Admin, Mod, Verified
			$Status = "";
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
			}

			if(($VeriSt = Verified::find($userID)) != null){
				if($VeriSt->status=='Pending'){

					if($Status=="")
						$Status = 'Pending Verified Account Request';

					array_push($pendingUsers, array($user->id,
									$user->username,
									(new Carbon($user->registered))->format('d/m/y h:m'),
									$VeriSt->description));
				}
				else{
					if($Status=="")
						$Status = 'Verified Account';

					$userVeri = 'Verified';
				}
			}

			if($Status=="")
				$Status = 'Normal';

			array_push($users, array($user->id,
						 $user->username,
						 (new Carbon($user->registered))->format('d/m/y h:m'),
						 $Status,
						 $userVeri));
		}
		return array($users, $pendingUsers);
	}

	public function getPosts(){
	}
	public function getReports(){
	}

	public function showPage(){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
		$recentUsers = $this->getRecentUsers();
		return view('admin.admin', compact('recentUsers'));
	}
	   
	public function showUsersPage(){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
		$arrUsers = $this->getUsers();
		$pendingUsers = $arrUsers[1];
		$users = $arrUsers[0];
		return view('admin.admin-users')->with(compact('pendingUsers', 'users'));
	}

	public function showPostsPage(){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
		$this->getPosts();
		return view('admin.admin-posts');
	}
	   
	public function showReportsPage(){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
		$this->getReports();
		return view('admin.admin-reports');
	}
	
	public function verifyUser($id){

		if(null==$this->checkUser()){
			return view('errors.404');
		}

		if(User::find($id)==null)
			return back()->with('failure', 'Account doesn\'exist!');
		
		
		if(($VeriSt = Verified::find($id)) != null){
			if($VeriSt->status=='Pending'){
				$VeriSt->status = 'Verified';
				$VeriSt->save();
			}else{
				$VeriSt->delete();
				return back()->with('success', 'Deleted verification!');
			}
		}
		
		Verified::create(array('id' => $id, 
						    'status'=> 'Verified', 
						    'verified'=> ((string)now()->addHour() .'+00'),
						    'description' => 'Request verified'));

		return back()->with('success', 'Verified account!');
	}

	public function moderatorUser($id){

		if(null==$this->checkUser()){
			return view('errors.404');
		}
	
		if(User::find($id)==null)
			return back()->with('failure', 'Account doesn\'exist!');
		
		
	}

}
