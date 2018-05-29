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


class AdminController extends Controller
{

	public function verifyUserIsAdmin(){
	}

	public function getRecentUsers(){
	}
	public function getUsers(){
	}
	public function getPosts(){
	}
	public function getReports(){
	}

	public function showPage(){
		$this->verifyUserIsAdmin();
		$this->getRecentUsers();
		return view('admin.admin');
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
