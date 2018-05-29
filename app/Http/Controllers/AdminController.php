<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

class AdminController extends Controller
{

	public function verifyUserIsAdmin(){
	
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
	}
	public function getPosts(){
	}
	public function getReports(){
	}

	public function showPage(){
		if(null==$this->verifyUserIsAdmin()){
			return view('errors.404');
		}
		$recentUsers = $this->getRecentUsers();
		return view('admin.admin', compact('recentUsers'));
	}
	   
	public function showUsersPage(){
		$this->verifyUserIsAdmin();
		$this->getUsers();
		return view('admin.admin-users');
	}

	public function showPostsPage(){
		$this->verifyUserIsAdmin();
		$this->getPosts();
		return view('admin.admin-posts');
	}
	   
	public function showReportsPage(){
		$this->verifyUserIsAdmin();
		$this->getReports();
		return view('admin.admin-reports');
	}
}
