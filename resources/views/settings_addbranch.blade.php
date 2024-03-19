@extends('templates.modaltemplate')

@section('content')
    <form method="POST" action="/settings_addbranchprocess" target="_parent">
        @csrf
        <h4 class="mb-3">Add A New Branch</h4>

        <div class="form-outline mb-3">
            <input class="form-control" id="name" name="name" type="name" required>
            <label class="form-label" for="name">Branch Name*</label>
        </div>

        <div class="form-outline mb-3">
            <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
            <label class="form-label" for="address">Address*</label>
        </div>


        <div class="form-outline mb-3">
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            <label class="form-label" for="description">Description*</label>
        </div>


        <button class="btn btn-dark mt-3 float-end" type="submit">Add Branch</button>
    </form>
@endsection
