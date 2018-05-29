@extends('layouts.master')

@section('title', "Content Policy" )

@section('content')
<div class="container-fluid">

      <h1 class="mt-3">Ditto Content Policy</h1>
      <hr>
      <section class="pb-3">
          <p>Ditto wants you to understand all the rules and how we treat your information inside our webservers. </p>
          <p>In order to be more effective, this Content Policy serves the purpose of being a two-way contract between us and the user at the moment of registration.</p>
          <p>Effective 11th March, 2018. </p></pp>
      </section>

      <section class="pb-3">
          <h2 class="my-4">Conduct</h2>
          <hr>

         <p>We think the healthiest community is possible when users follow these guidelines:</p>

          <ul class="list-group list-group-flush">
              <li class="list-group-item">Content is prohibited if it is illegal.</li>
              <li class="list-group-item">Content is prohibited if it is involuntary pornography.</li>
              <li class="list-group-item">Content is prohibited if it is sexual or suggestive content involving minors.</li>
              <li class="list-group-item">Content is prohibited if it encourages or incites violence.</li>
              <li class="list-group-item">Content is prohibited if it threatens, harasses, or bullies or encourages others to do so.</li>
              <li class="list-group-item">Content is prohibited if it is personal and confidential information.</li>
              <li class="list-group-item">Content is prohibited if it is spam.</li>
          </ul>

      </section>
      <section class="pb-3">
          <h2 class="my-4">Information We Collect</h2>
          <hr>

          <p>The visitors are free to navigate through our website without providing any personally identifiable information if they do not want to register with us.</p>
          <p>To use all the functionality of our web application you need to register to our site. We do not collect more information than is absolutely necessary to allow your participation in an activity on the website.</p>

      </section>

      <section class="pb-3">
          <h2 class="my-4">How We Use Information About You</h2>
          <hr>

          <p>We do not sell your personal information to others. The personally identifiable Information you submit to receive information and services from our website will never be disclosed to any third party. We use this personally identifiable information to register you to access our services and verify your authority to access the courses and services.</p>

      </section>

      <section class="pb-3">
          <h2 class="my-4">Security</h2>
          <hr>

          <p>We store all the collected information on our secure servers. As a registered user, you can access your account with a unique user name and a password as selected by you. You are responsible for keeping your password confidential. To ensure better security, we recommend that you choose a strong password containing alphabets, numbers, and special characters, and that you change your password periodically.</p>

          <p>We employ the best mechanisms possible to protect your Personal Information, however we cannot be held responsible for any breach of security unless it is caused as a direct result of our negligence. Unfortunately data transmission over the internet is not 100% secure and as a registered user of this website, you agree that we are not accountable for any data loss due to the limitations of the internet which are beyond our control.</p>

          <p>In the unlikely event of a breach in security systems, we may notify you through email so that you can take suitable protective measures.</p>

      </section>

      <section class="pb-3">
          <h2 class="my-4">International Users </h2>
          <hr>

          <p> Ditto and its Services are based in Portugal.
          <p>Please be aware that information you provide to Ditto that it obtains as a result of your use of the Services may be processed and transferred to Portugal and be subject to the Portuguese law's. </p>
          <p>By using the Website, providing Ditto with your information, you consent to this collection, transfer, storage, and processing of information to and in Portugal. </p>
          <p>Ditto will take all steps reasonably necessary to ensure that your data is treated securely in accordance with this Content Policy.</p>

      </section>

      <section class="pb-3">
          <h2 class="my-4">Contact Us</h2>
          <hr>

          <p> If you have any question feel free to <a href="{{ url("/contact") }}">contact us</a>. </p>

      </section>




      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Content Policy</li>
          </ol>
      </nav>

  </div>

  @include('layouts.footer')

@endsection
