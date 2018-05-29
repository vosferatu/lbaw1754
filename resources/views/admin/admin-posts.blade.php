@extends('auth.master')

    <!-- Bootstrap core CSS
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">-->

@push('styles')
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')

<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Ditto Admin</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin')}}">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin-users')}}">
                            <span data-feather="users"></span>
                            Users <span class="badge badge-success">1</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{url('/admin-posts')}}">
                            <span data-feather="file-text"></span>
                            Posts
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admin-reports')}}">
                            <span data-feather="flag"></span>
                            Reports <span class="badge badge-warning">3</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 pt-3 px-4">
            <h2>Posts</h2>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Posts</li>
                    </ol>
                    <!-- Example DataTables Card-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Latest Posts
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Short</th>
                                        <th>Date</th>
                                        <th>Creator</th>
                                        <th># Votes</th>
                                        <th># Com</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Short</th>
                                        <th>Date</th>
                                        <th>Creator</th>
                                        <th># Votes</th>
                                        <th># Com</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <tr>
                                        <td>001</td>
                                        <td>Oscars 2018: What to expect from this year's ceremony</td>
                                        <td>The Oscars are taking place later, in the shadow of the sexual assault scandal that has rocked the industry in recent months.</td>
                                        <td>4/3/2018 12:45</td>
                                        <td>Publico</td>
                                        <td>10</td>
                                        <td>2</td>
                                        <td>
                                            <a href="#" data-toggle="tooltip" title="View Thread">
                                                <span data-feather="book-open"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Close Discussion">
                                                <span data-feather="message-circle" style="color: red"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Delete Post">
                                                <span data-feather="trash" style="color: red"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td>002</td>
                                    <td>Davide Astori: Fiorentina captain and Italy international dies at the age of 31 </td>
                                    <td>Fiorentina captain and Italy international Davide Astori has died at the age of 31.</td>
                                    <td>4/3/2018 12:00</td>
                                    <td>kevin</td>
                                        <td>9</td>
                                        <td>3</td>
                                        <td>
                                            <a href="#" data-toggle="tooltip" title="View Thread">
                                                <span data-feather="book-open"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Close Discussion">
                                                <span data-feather="message-circle" style="color: red"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Delete Post">
                                                <span data-feather="trash" style="color: red"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>003</td>
                                        <td>AI finds novel way to beat classic Q*bert Atari video game</td>
                                        <td>Atari video game Q*bert has been beaten by an Artificial Intelligence program, which exploited a loophole that had never previously been discovered.</td>
                                        <td>4/3/2018 9:00</td>
                                        <td>joseRocha, conceicao1</td>
                                        <td>15</td>
                                        <td>10</td>
                                        <td>
                                            <a href="#" data-toggle="tooltip" title="View Thread">
                                                <span data-feather="book-open"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Close Discussion">
                                                <span data-feather="message-circle" style="color: red"></span>
                                            </a>
                                            <a href="#" data-toggle="tooltip" title="Delete Post">
                                                <span data-feather="trash" style="color: red"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
                <!-- /.container-fluid-->
                <!-- /.content-wrapper-->
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<!-- Bootstrap core JavaScript-->
<script src="../../../Desktop/ditto%20admin/js/vendor/bootstrap.min.js"></script>
<script src="../../../Desktop/ditto%20admin/js/vendor/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

<!-- Bootstrap core JavaScript-->
<!-- Core plugin JavaScript-->
<script src="../../../Desktop/ditto%20admin/js/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="../../../Desktop/ditto%20admin/js/vendor/datatables/jquery.dataTables.js"></script>
<script src="../../../Desktop/ditto%20admin/js/vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="../../../Desktop/ditto%20admin/js/sb-admin.min.js"></script>
<!-- Custom scripts for this page-->
<script src="../../../Desktop/ditto%20admin/js/sb-admin-datatables.min.js"></script>
</body>
</html>

@endsection
