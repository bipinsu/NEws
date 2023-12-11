@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
    <div class="content">
        <div class="overview">
            <div class="title">
                <i class='bx bx-customize'></i>
                <span class="text">Nav Content</span>
            </div>
            <div class="back">
                <a href="{{ route('admin.nav_contents.index') }}">
                    <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
                </a>
            </div>
            <div class="create-role-form">
                <form action="{{ route('admin.nav_contents.store') }}" method="post">
                    @csrf
                    <div class="forms-input">
                        <label for="name">Header Name</label>
                        <input type="text" name="name" class="name">
                        <div class="error-container">
                            @error('name')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <label for="sub_name">Sub-Header Name</label>
                        <textarea name="sub_name" class="name"></textarea>


                        <div class="error-container">
                            @error('sub_name')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>


                        <button type="submit" class="create-btn">Create</button>
                    </form>
                </div>


            </div>
        </div>
    @endsection
