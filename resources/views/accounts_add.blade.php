@extends('templates.modaltemplate')

@section('content')
    <form method="POST" action="/accounts_addprocess" target="_parent" enctype="multipart/form-data">
        @csrf
        <h4 class="mb-3">Add A New Account</h4>

        <div class="form-outline mb-3">
            <input class="form-control" id="username" name="username" type="username" required>
            <label class="form-label" for="username">Username*</label>
        </div>

        <div class="form-outline mb-3" style="min-width:200px">
            <a id="show1" href="#" style="color: inherit;"><i class="fas fa-eye-slash trailing pe-auto" id="eye1"></i></a>
            <input class="form-control" id="password" name="password" type="password" required />
            <label class="form-label" for="password">Password*</label>
        </div>

        <div class="form-outline mb-3" style="min-width:200px">
            <a id="show2" href="#" style="color: inherit;"><i class="fas fa-eye-slash trailing pe-auto" id="eye2"></i></a>
            <input class="form-control" id="password2" name="password2" type="password" required />
            <label class="form-label" for="password2">Confirm Password*</label>
        </div>

        <div class="input-group mb-3">
            <div class="form-outline">
                <input class="form-control" id="firstname" name="firstname" type="text" required>
                <label class="form-label" for="firstname">First Name*</label>
            </div>
            <div class="form-outline">
                <input class="form-control" id="middlename" name="middlename" type="text">
                <label class="form-label overflow-x-scroll pe-2" for="middlename">Middle Name</label>
            </div>
            <div class="form-outline">
                <input class="form-control" id="lastname" name="lastname" type="text" required>
                <label class="form-label" for="lastname">Last Name*</label>
            </div>
        </div>

        <div class="form-outline mb-3">
            <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
            <label class="form-label" for="address">Address*</label>
        </div>

        <div class="form-outline mb-4">
            <input class="form-control" id="contactInput" name="mobilenumber" data-mdb-showcounter="true" type="number" maxlength="11" min="0" pattern="/^-?\d+\.?\d*$/"
                onKeyPress="if(this.value.length==11) return false;" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187" required>
            <label class=" form-label" for="contactInput">Mobile Number*</label>
            <div class="form-helper"></div>
        </div>

        <div class="input-group mb-3">
            <select class="form-select" id="type" name="type" required>
                <option value="" selected hidden>Account Type*</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <select class="form-select" id="branch" name="branch" required>
                <option value="" selected hidden>Branch*</option>
                @php
                    $branch = DB::table('branches')->get()->toArray();
                @endphp

                @foreach ($branch as $br)
                    <option value="{{ $br->id }}">{{ $br->name }}</option>
                @endforeach
            </select>
        </div>

        <label class="form-label" for="InputGroupFile01">Image:</label>
        <div class="input-group mb-3">
            <input class="form-control" id="inputGroupFile01" name="image" type="file" accept="image/jpeg,image/png">
        </div>


        <button class="btn btn-dark mt-3 float-end" type="submit">Add Account</button>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#show1').on('click', function() {
                if ($('#password').attr('type') == "text") {
                    $('#password').attr('type', 'password');
                    $('#eye1').addClass("fa-eye-slash");
                    $('#eye1').removeClass("fa-eye");
                } else {
                    $('#password').attr('type', 'text');
                    $('#eye1').addClass("fa-eye");
                    $('#eye1').removeClass("fa-eye-slash");
                }
            });
            $('#show2').on('click', function() {
                if ($('#password2').attr('type') == "text") {
                    $('#password2').attr('type', 'password');
                    $('#eye2').addClass("fa-eye-slash");
                    $('#eye2').removeClass("fa-eye");
                } else {
                    $('#password2').attr('type', 'text');
                    $('#eye2').addClass("fa-eye");
                    $('#eye2').removeClass("fa-eye-slash");
                }
            });
            $('#province').change(function() {
                $('#munhide').removeAttr('hidden');
                var value1 = $('#province').val();
                $.get('/getMunicipality/' + encodeURIComponent(value1), function(data) {
                    var options = '<option selected hidden value="">Municipality*</option>';
                    var sortedData = Object.entries(data).sort((a, b) => a[1].localeCompare(b[1]));

                    $.each(sortedData, function(key, value) {
                        options += '<option value="' + value[0] + '">' + value[1] + '</option>';
                    });

                    $('#municipality').html(options);
                });
            });
        });
    </script>
@endpush
