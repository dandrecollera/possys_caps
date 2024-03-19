@extends('templates.modaltemplate')

@section('content')
    <form method="POST" action="/settings_editbranchprocess" target="_parent">
        @csrf
        <h4 class="mb-3">Edit A Branch</h4>

        <div class="form-outline mb-3">
            <input class="form-control" id="name" name="name" type="name" value="{{ $db->name }}" required>
            <label class="form-label" for="name">Branch Name*</label>
        </div>

        <div class="form-outline mb-3">
            <textarea class="form-control" id="address" name="address" rows="2" required> {{ $db->address }}</textarea>
            <label class="form-label" for="address">Address*</label>
        </div>


        <div class="form-outline mb-3">
            <textarea class="form-control" id="description" name="description" rows="3">{{ $db->description }}</textarea>
            <label class="form-label" for="description">Description*</label>
        </div>

        <input name="id" type="hidden" value="{{ $db->id }}">

        <button class="btn btn-dark mt-3 float-end" type="submit">Save Branch</button>
    </form>
@endsection
