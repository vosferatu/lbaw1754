<nav class="navbar rounded navbar-expand-lg navbar-light">
        <div class="brand">
           <a href={{url('/')}}> <img src={{ url('/img/logo.svg')}}></a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            
            <ul id="navbarLinks" class="navbar-nav mr-auto">
                    
                <li class="trending nav-item ml-3"><a href={{ route('trending') }} class="nav-link"> <i class="fas fa-bolt"></i> Trending</a>
                </li>
                <li class="latest nav-item ml-3"><a href={{ route('postsByDate') }} class="nav-link"><i class="fas fa-clock"></i> Latest</a></li>

                <li class="feed nav-item ml-3"><a href="feed.html" class="nav-link"> <i class="fas fa-leaf"></i> Feed</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item ml-3">
                    <form id="demo-2" action="{{route('searchpost')}}" method="post">
                            {{ csrf_field() }}
                        <input name="text" type="search" placeholder="Search">
                    </form>
                </li>

          @if (Auth::check())
          <li class="nav-item mx-3" data-toggle="modal" data-target="#exampleModalCenter">
              <a href="{{ route('post.create') }}" class="nav-link active">
                  <i class="fas fa-pencil-alt"></i> New Post</a> </li>

          <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action active"><img
                      src="https://www.tutorialrepublic.com/examples/images/avatar/2.jpg" class="avatar"
                      alt="Avatar"> {{ Auth::user()->username }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="/user/{{ Auth::user()->id  }}" class="dropdown-item"><i class="fas fa-user"></i> My Profile</a></li>
                  <li><a href="/user/{{ Auth::user()->id  }}/drafts" class="dropdown-item"><i class="fas fa-edit"></i> My Drafts</a></li>
                  <li class="divider dropdown-divider"></li>
                  <li><a href="{{ route('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
              </ul>
          </li>


          @else
          <li class="nav-item ml-3"><a href={{ route('register') }} class="nav-link"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                <li class="nav-item ml-3"><a href={{ route('login') }} class="nav-link"> <i class="fas fa-sign-in-alt"></i> Sign In</a></li>

          @endif



            </ul>
        </div>

    </nav>
