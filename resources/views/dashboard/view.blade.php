<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row mx-3 mb-3">
        <div class="col-md-12">
            <div class="float-left">
                <h5>Dashboard</h5>
            </div>

        </div>
        <div class="col-md-12 mt-5 text-center">
            <h1>Welcome {{ Auth::user()->fullname }}, <br>
            You Logged as {{ Auth::user()->AdminGroup->name }}</h1>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- /.container-fluid -->
