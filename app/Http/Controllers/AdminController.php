<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Post;
use App\Content;
use App\Comment;
use App\NewsCreation;
use App\Upvote;
use App\Downvote;
use App\ContentReport;
use App\Save;
use App\Tag;
use App\Admin;
use App\User;
use App\Verified;
use App\Moderator;
use App\Ban;
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
		$timeNow = ((string)now()->subDays(9)).'+00';
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
			$userVeri = 'Not Verified';
			$userMod = 'Not Moderator';
			$userBan = 'Not Banned';
			$Status = "";
			if(DB::table('inactive')->find($userID) != null){
				$Status = 'Inactive';
			}
			

			if(DB::table('banned')->find($userID) != null){
				if($Status=="")
					$Status = 'Permanently Banned';
				$userBan = 'Banned';
			}else
			if(DB::table('kicked')->find($userID) != null){
				$Status = 'Temporarily Banned';
			}else
			if(DB::table('administrator')->find($userID) != null){
				$Status = 'Administrator';
			}			

			if(Moderator::find($userID) != null){
				if($Status=="")
					$Status = 'Moderator';
				$userMod = 'Moderator';
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
						 $userVeri,
						 $userMod,
 						 $userBan));
		}
		return array($users, $pendingUsers);
	}

	public function getPosts(){
		
		$posts = array();

		$news = Post::all();

		foreach($news as $newsPost){
			$id = $newsPost->id;
			$content = Content::find($id);
			$authors = NewsCreation::where('id_news', $id)->get();
			$authorsNames = array();
			foreach($authors as $authorID){
				array_push($authorsNames,User::find($authorID->id_user)->username);
			}
			$NDownvotes = Downvote::where('id_content', $id)->count();
			$NUpvotes = Upvote::where('id_content', $id)->count();
			$NComments= Comment::where('parent_news',$id)->count();
			array_push($posts, array($id,
						$newsPost->title,
						substr($content->text, 0, 30),
						$content->created,
						$authorsNames,
						$NUpvotes-$NDownvotes,
						$NComments
						));
		}
		return $posts;

	}
	public function getReports(){
	}


	public function getRegsN(){
		$week = array(0 => 'Monday',
				1 => 'Tuesday',
				2 => 'Wednesday',
				3 => 'Thursday',
				4 => 'Friday',
				5 => 'Saturday',
				6 => 'Sunday'
			);
		$daysOfTheWeek = array();
		$numberRegs = array();
		$startDay = Carbon::now()->subWeeks(1);
		for($i = 0; $i< 7; $i++){
			array_push($daysOfTheWeek, $week[$startDay->dayOfWeek]);
				
			$endDay = $startDay;
			

			array_push($numberRegs, User::whereBetween('registered',array($endDay . '+00', $startDay->addDays(1) . '+00'))
						->get()->count());
			
		}
		return array($daysOfTheWeek, $numberRegs);
	}

	public function showPage(){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
		$recentUsers = $this->getRecentUsers();
		$countRegsDays = $this->getRegsN();
		return view('admin.admin', compact('recentUsers','countRegsDays'));
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
		$posts = $this->getPosts();
		return view('admin.admin-posts', compact('posts'));
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

		if(($modSt = Moderator::find($id)) != null){
			$modSt->delete();
			return back()->with('success', 'Account is no longer moderator!');
		}

		Moderator::create(array('id' => $id, 
				        'started'=> ((string)now()->addHour() .'+00')));

		return back()->with('success', 'Account is now moderator!');
	}

	public function banUser($id){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
	
		if(User::find($id)==null)
			return back()->with('failure', 'Account doesn\'exist!');

		if(($banSt = Ban::find($id)) != null){
			$banSt->delete();
			return back()->with('success', 'Account is no longer banned!');
		}

		Ban::create(array('id' => $id));

		return back()->with('success', 'Account is now banned!');
	}

	public function deleteUser($id){
		if(null==$this->checkUser()){
			return view('errors.404');
		}
	
		if(($userSt=User::find($id))==null)
			return back()->with('failure', 'Account doesn\'exist!');
		
		$userSt->delete();
		return back()->with('success', 'Account is no longer banned!');
	}

}
