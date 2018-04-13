@extends('layouts.master')

@section('content')

	<div class="container-fluid ">
		<h1 class="mt-3">Contact Us!</h1>
		<hr>
		<section class="pb-3">
		<p class="card-text">If you have any idea, suggestion, question, or if you just want to buy us a beer, here is the form below!</p>

			<form class="container">

				<div class="form-group">
					<input type="text" class="form-control" id="name" placeholder="Name">
				</div>

				<div class="form-group">
					<input type="email" class="form-control" id="email" placeholder="Email">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="subject" placeholder="Subject">
				</div>


				<div class="form-group">
					<textarea class="form-control" id="message" rows="3" placeholder="Message"></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-lg">Send  <i class="fas fa-paper-plane"></i></button>
			</form>
		</section>



		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Contact</li>
			</ol>
		</nav>



	</div>
	@include('layouts.footer')

  @endsection
