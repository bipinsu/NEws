@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bxs-lock-open'></i>
            <span class="text">Import User</span>
        </div>
        
        <div class="back">
            <a href="{{route('admin.users.index')}}">
            <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
            </a>
        </div> <br>
        
        <div class="create-role-form">
            <
            <form action="{{route('admin.users.import.store')}}" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="forms-input">
                    <label for="import_file">CSV File Import</label><br>
                    <input type="file" name="import_file" class="import_file" >
                    <div class="error-container"> 
                        @error('import_file')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                
                <button type="submit" class="create-btn">Upload File</button>
            </form>
        </div>
        
   
    </div>
</div>
@endsection