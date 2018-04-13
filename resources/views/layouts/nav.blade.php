<nav class="navbar rounded navbar-expand-lg navbar-light">
        <div class="brand">
           <a href="trending.html"> <img src={{ url('/img/logo.svg')}}></a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ml-3 active"><a href="trending.html" class="nav-link"> <i class="fas fa-bolt"></i> Trending</a>
                </li>
                <li class="nav-item ml-3"><a href="latest.html" class="nav-link"><i class="fas fa-clock"></i> Latest</a></li>

                <li class="nav-item ml-3"><a href="feed.html" class="nav-link"> <i class="fas fa-leaf"></i> Feed</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item ml-3">
                    <form id="demo-2">
                        <input type="search" placeholder="Search">
                    </form>
                </li>
                <li class="nav-item mx-3" data-toggle="modal" data-target="#exampleModalCenter"><a href="#"
                                                                                                   class="nav-link active"><i
                        class="fas fa-pencil-alt"></i> New Post</a></li>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action active"><img
                            src="https://www.tutorialrepublic.com/examples/images/avatar/2.jpg" class="avatar"
                            alt="Avatar"> Cátia Ribeiro <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.html" class="dropdown-item"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="drafts.html" class="dropdown-item"><i class="fas fa-edit"></i> My Drafts</a></li>
                        <li class="divider dropdown-divider"></li>
                        <li><a href="#" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>


        <!-- New Post Modal -->
        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">New Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="title" placeholder="Title">
                            </div>

                            <div class="form-group">
                            <textarea name="editor" id="editor" rows="10" cols="80" placeholder="Article"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="tags" placeholder="Add Tags"> <span class="badge badge-pill badge-success">Photography</span> <span class="badge badge-pill badge-success">Technology</span>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark mr-auto"><i class="fas fa-user-plus"></i> Add Author</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success">Save</button>
                        <button type="button" class="btn btn-outline-primary">Publish</button>
                    </div>
                </div>
            </div>
        </div>

    </nav>
