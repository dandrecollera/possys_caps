@extends('templates.templatev3')

@section('content')
    <div class="container-fluid">

        @if (!empty($error))
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Error</h4>
                        <p>{{ $errorlist[(int) $error] }}</p>
                        <button class="btn-close" data-mdb-dismiss="alert" type="button"></button>
                    </div>
                </div>
            </div>
        @endif
        @if (!empty($notif))
            <div class="row">
                <div class="col">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Success</h4>
                        <p>{{ $notiflist[(int) $notif] }}</p>
                        <button class="btn-close" data-mdb-dismiss="alert" type="button"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">System Settings</h3>
                <a class="btn btn-dark btn-sm" data-mdb-ripple-init href="/systemdefault" style="font-size: 10px">Return to Default Settings</a>
                <form action="/savesettings" method="POST" enctype="multipart/form-data">
                    @csrf

                    <p class="mb-0 mt-4 mb-2">System Title</p>
                    <div class="form-outline">
                        <input class="form-control" id="title" name="title" type="text" />
                        <label class="form-label" for="title">System Title</label>
                    </div>
                    <p class="mb-3" style="font-size: 11px; color:rgb(133, 133, 133); font-style:italic">If you will not change the title. You may leave this field empty.*</p>

                    <p class="mb-0 mb-2">System Logo</p>
                    <div class="form-outline">
                        <input class="form-control" id="image" name="image" type="file" />
                    </div>
                    <p class="mb-3" style="font-size: 11px; color:rgb(133, 133, 133); font-style:italic">File dimension must be 500 by 500 pixels</p>

                    <button class="btn btn-dark me-auto" data-mdb-ripple-init type="submit">Save Settings</button>

                </form>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h3 class="card-title">Branch Management</h3>


            </div>
        </div>

    </div>
@endsection
