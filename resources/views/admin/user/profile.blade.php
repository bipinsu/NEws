@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">
{{-- JS --}}
<script defer  src="/js/login/login.js"></script>
@section('main')
<div class="back">
    <a href="{{route('admin.users.index')}}">
    <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
    </a>
</div>
<div class="content">
    <div class="overview">
        <div class="title">
            <span class="text">User Profile</span>
        </div>
        <div class="update_form">
            @if(session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.users.profileUpdate') }}" class="update_profile">
                @csrf
                <div class="forms-input">
                    <div class="old_password_field">
                        <label for="name">Old Password</label>
                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="current-password">
                        <i class='bx bx-hide eye-icon'></i>
                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="new_password_field">
                        <label for="name">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <i class='bx bx-hide eye-icon'></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="create-btn">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password :</div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.profileUpdate') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                            <div class="col-md-6">
                                    <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="current-password">
                                    <i class='bx bx-hide eye-icon'></i>
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <i class='bx bx-hide eye-icon'></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}
