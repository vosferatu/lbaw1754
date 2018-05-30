@extends('auth.master')

@push('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="forgot-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">

				<div class="card-wrapper">
					<div class="brand">
						<img src="../images/logo.svg">
					</div>

					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Forgot Password</h4>
							<form method="POST">
							 
								<div class="form-group">
									<label for="email">E-Mail</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="form-text text-muted">
										By clicking "Reset Password" we will send you a password reset link.
									</div>
								</div>

								<div class="form-group no-margin">
									<button type="submit" class="btn btn-primary btn-block">
										Reset Password
									</button>
								</div>
							</form>
						</div>
					</div>
					<footer>
						<a href="../index.html">Homepage</a> &middot; <a href="about.html">About</a> &middot; <a
							href="FAQ.html">FAQ</a> &middot; <a href="policy.html">Content Policy</a> &middot; <a
							href="contact.html">Contact</a>
					</footer>
				</div>
			</div>
		</div>
	</section>
</body>
</html>