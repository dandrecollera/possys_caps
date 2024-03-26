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

        <div class="card mt-3">
            <div class="card-body">
                <h3 class="card-title">Account Management</h3>

                <button class="btn btn-dark shadow-sm btn-sm " id="addbutton" data-mdb-toggle="modal" data-mdb-target="#addeditmodal" type="button"><i class="fa-solid fa-circle-plus me-2"></i> Add A New Account</button>

                <hr>

                <div class="row">
                    <div class="col">
                        <form method="get">

                            <div class="input-group mb-3">
                                <input class="form-control" name="keyword" type="search" value="{{ !empty($keyword) ? $keyword : '' }}" placeholder="Search Keyword" required>
                                <button class="btn btn-dark" type="submit"><i class="fas fa-search fa-sm"></i></button>
                                @if (!empty($keyword))
                                    <button class="btn btn-dark" type="button" onclick="location.href='./settings'"><i class="fas fa-search fa-rotate fa-sm"></i></button>
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <div>
                                    <button class="btn btn-dark dropdown-toggle" data-mdb-toggle="dropdown" type="button">
                                        {{ $lpp == 25 ? 'ITEMS' : $lpp }}</button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="?lpp=3{{ !empty($keyword) ? ' &keyword=' . $keyword : '' }}">
                                                3 Lines Per Page
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="?lpp=25{{ !empty($keyword) ? ' &keyword=' . $keyword : '' }}">
                                                25 Lines Per Page
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="?lpp=50{{ !empty($keyword) ? ' &keyword=' . $keyword : '' }}">
                                                50 Lines Per Page
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="?lpp=100{{ !empty($keyword) ? ' &keyword=' . $keyword : '' }}">
                                                100 Lines Per page
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="?lpp=200{{ !empty($keyword) ? ' &keyword=' . $keyword : '' }}">
                                                200 Lines Per Page
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <button class="btn btn-dark dropdown-toggle" data-mdb-toggle="dropdown" type="button">{{ $orderbylist[$sort]['display'] == 'Default' ? 'SORT' : $orderbylist[$sort]['display'] }} </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($orderbylist as $key => $odl)
                                            @php
                                                $qstringsort = $qstring2;
                                                $qstringsort['sort'] = $key;
                                                $sorturl = http_build_query($qstringsort);
                                            @endphp
                                            <li><a class="dropdown-item" href="?{{ $sorturl }}">{{ $odl['display'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                @if (!empty($sort) || $lpp != 25 || !empty($type))
                                    <button class="btn btn-dark" type="button" onclick="location.href='./settings'"><i class="fas fa-search fa-rotate fa-sm"></i></button>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>


                <div class="row">
                    <div class="col overflow-scroll scrollable-container mb-2">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">

                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Default' ? 'main-primary' : '' }}"><strong>ID</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Username' ? 'main-primary' : '' }}"><strong>Username</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span
                                            class="{{ $orderbylist[$sort]['display'] == 'First Name' || $orderbylist[$sort]['display'] == 'Middle Name' || $orderbylist[$sort]['display'] == 'Last Name' ? 'main-primary' : '' }}"><strong>Name</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Type' ? 'main-primary' : '' }}"><strong>Type</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Branch' ? 'main-primary' : '' }}"><strong>Branch</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Last Active' ? 'main-primary' : '' }}"><strong>Last Active</strong></span>
                                    </th>
                                    <th scope="col">
                                        <span class="{{ $orderbylist[$sort]['display'] == 'Status' ? 'main-primary' : '' }}"><strong>Status</strong></span>
                                    </th>
                                    <th scope="col">
                                        <strong>Actions</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dbresult as $dbr)
                                    <tr class="{{ $dbr->status == 'inactive' ? 'table-danger' : '' }}">
                                        <th scope="row"><strong><img class="rounded-circle me-lg-0 me-2 dpcover" src="{{ asset('/storage/images/' . $dbr->photo) }}" alt="" height="40" width="40"
                                                    loading="lazy" /></strong></th>
                                        <th scope="row">{{ $dbr->id }}</th>
                                        <td>{{ $dbr->username }}</td>
                                        <td>{{ $dbr->firstname }} {{ $dbr->middlename }} {{ $dbr->lastname }}</td>
                                        <td style="text-transform: capitalize;">{{ $dbr->type }}</td>
                                        <td>{{ $dbr->name }}</td>
                                        <td>{{ $dbr->last_active ? Carbon\Carbon::parse($dbr->last_active)->format('F j, Y g:iA') : '' }}</td>
                                        <td style="text-transform: capitalize;">{{ $dbr->status }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary btn-sm azu-edit" data-id="{{ $dbr->id }}" data-mdb-toggle="modal" data-mdb-target="#addeditmodal" data-toggle="popover"
                                                    data-mdb-trigger="hover" data-mdb-placement="top" type="button"title="Edit">
                                                    <i class="fa-solid fa-pen fa-xs"></i>
                                                </button>

                                                @if ($dbr->status != 'inactive')
                                                    <button class="btn btn-dark btn-sm azu-lock" data-status="{{ $dbr->status }}" data-id="{{ $dbr->id }}" data-mdb-toggle="modal" data-mdb-target="#lockmodal"
                                                        data-toggle="popover" data-mdb-trigger="hover" data-mdb-placement="top" type="button"title="Archive">
                                                        <i class="fa-solid fa-lock fa-xs"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm azu-unlock" data-status="{{ $dbr->status }}" data-id="{{ $dbr->id }}" data-mdb-toggle="modal"
                                                        data-mdb-target="#lockmodal" data-toggle="popover" data-mdb-trigger="hover" data-mdb-placement="top" type="button"title="Unarchive">
                                                        <i class="fa-solid fa-lock-open  fa-xs"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="input-group mb-4">
                        {!! $page_first_url !!}
                        {!! $page_prev_url !!}
                        <span class="form-control text-center text-white pt-2" id="basic-addon3" style="max-width: 75px; background-color:#262626; border: none; font-size: 13px">{{ $page }} /
                            {{ $totalpages }}</span>
                        {!! $page_next_url !!}
                        {!! $page_last_url !!}
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addeditmodal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addeditmodalLabel">
                        <div>Modal title</div>
                    </h1>
                    <button class="btn-close" data-mdb-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <iframe id="addeditframe" src="/adminuser_add" style="border:none; height:80vh;" width="100%" height="450px"></iframe>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="lockmodal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="lockmodalLabel">
                        <div>Modal title</div>
                    </h1>
                    <button class="btn-close" data-mdb-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <p id="lockmodalbody"></p>
                    <div class="justify-content-end d-flex">
                        <div class="btn-group">
                            <a class="btn btn-danger" data-mdb-dismiss="modal">Cancel</a>
                            <a class="btn btn-primary" id="lockbutton" href="">Confirm</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addbutton').on('click', function() {
                $('#addeditmodalLabel').html('Adding New Account');
                $('#addeditframe').attr('src', '/accounts_add');
            });
            $('.azu-edit').on('click', function() {
                let sid = $(this).data('id');
                $('#addeditmodalLabel').html('Edit Account');
                $('#addeditframe').attr('src', '/accounts_edit?id=' + sid);
            })
            $('.azu-lock, .azu-unlock').on('click', function() {
                let sid = $(this).data('id');
                let status = $(this).data('status');
                let text = null;
                let text2 = null;

                if (status == 'active') {
                    text = 'Deactivate';
                    text2 = 'inactive';
                } else {
                    text = 'Activate';
                    text2 = 'active';
                }

                $('#lockmodalLabel').html(`${text} Account`);
                $('#lockmodalbody').html(`Are you sure you want to make this account ${text2}.`);
                $('#lockbutton').attr('href', `/accounts_lockunlockprocess?id=${sid}`);
            })
        });
    </script>
@endpush
