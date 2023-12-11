@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">
@section('main')
    <div class="back">
        <a href="{{route('admin.dashboard')}}">
        <button class="back-button"><i class='bx bx-chevron-left'></i> Back</button>
        </a>
    </div>
<h1>Edit Logo</h1>
        <form class="logo_edit" method="POST" action="{{ route('admin.logos.update', $logo->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="image">Logo Image:</label>
            <input type="file" name="image">

            <button type="submit">Update Logo</button>
        </form>
@endsection
