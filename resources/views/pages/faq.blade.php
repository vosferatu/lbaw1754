@extends('layouts.master')

@section('title', "FAQ" )

@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('content')
	<div class="container-fluid ">
		<h1 class="mt-3">Frequently Asked Questions (FAQ)</h1>
		<hr>
		<section class="pb-3">

			<div class="container-fluid text-center flex-row searchbox">
				<h2 class="faq-help">How can we help?</h2>
				<form class="form-inline my-2 my-lg-0">
					<div>
						<input class="form-control mr-sm-2 inputBig" type="text" placeholder="Search">
						<button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
					</div>
				</form>
			</div>



			<div id="accordion">
				<div class="card">
					<div class="card-header" id="headingOne">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								What is Ditto?
							</button>
						</h5>
					</div>

					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							Ditto is a web application where people can create articles about any topic and can cooperate with other people to write those same articles. It's like a social network for journalists and enthusiasts.
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingTwo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Can I eliminate a post?
							</button>
						</h5>
					</div>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						<div class="card-body">
							No, only the administrator can eliminate an article.
						</div>
					</div>
				</div>

        <div class="card">
          <div class="card-header" id="headingNine">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                Everybody can comment a post?
              </button>
            </h5>
          </div>
          <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
            <div class="card-body">
              You need to be autenticated to our website to be able to comment on a post.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="headingSix">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                What is an author?
              </button>
            </h5>
          </div>
          <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
            <div class="card-body">
              An author is a user who have published at least one post.
            </div>
          </div>
        </div>

        <div class="card">
					<div class="card-header" id="headingSeven">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
								There's a limit for how much authors I can associate to a post?
							</button>
						</h5>
					</div>
					<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
						<div class="card-body">
							There is no limit how much people can you associate to a post. Be aware that the post can only be published if every single author agree to publish.
						</div>
					</div>
				</div>

        <div class="card">
          <div class="card-header" id="headingFour">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                How can I change my information?
              </button>
            </h5>
          </div>
          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
            <div class="card-body">
              You can change your information in your profile page.
            </div>
          </div>
        </div>


				<div class="card">
					<div class="card-header" id="headingThree">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Why did I get banned?
							</button>
						</h5>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						<div class="card-body">
              <h4 class="card-title">Reasons for getting banned:</h4>
							<p class="card-text">
							<ul>
								<li>Content is prohibited if it is illegal.</li>
								<li>Content is prohibited if it is involuntary pornography.</li>
								<li>Content is prohibited if it is sexual or suggestive content involving minors.</li>
								<li>Content is prohibited if it encourages or incites violence.</li>
								<li>Content is prohibited if it threatens, harasses, or bullies or encourages others to do so.</li>
								<li>Content is prohibited if it is personal and confidential information.</li>
								<li>Content is prohibited if it is spam.</li>
							</ul>
              If you try to login to your account you can see why you were banned and when the ban will end if that is the case.
							</p>
						</div>
					</div>
				</div>
			</div>

      <div class="card">
        <div class="card-header" id="headingEight">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseheadingEight" aria-expanded="false" aria-controls="collapseheadingEight">
              I'm banned, what can I do now?
            </button>
          </h5>
        </div>
        <div id="collapseheadingEight" class="collapse" aria-labelledby="headingheadingEight" data-parent="#accordion">
          <div class="card-body">
            Theres's two types of bans, temporary ban and permanent ban. For the temporary ban you're account will be inaccessible for a short period of time. This states as a warning for violating our rules.
            The permanent ban you're account will be always inaccessible unless the administrator removes the ban. This ban is for those users who has received several warnings for violating our rules.
          </div>
        </div>
      </div>


      <div class="card">
        <div class="card-header" id="headingFive">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              What are the rules?
            </button>
          </h5>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
          <div class="card-body">
            You can consult our rules in the <a href="{{url("/contentpolicy")}}">content policy</a> page.
          </div>
        </div>
      </div>

		</section>

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">FAQ</li>
			</ol>
		</nav>

	</div>

	@include('layouts.footer')

@endsection
