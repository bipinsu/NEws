@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bxs-lock-open'></i>
            <span class="text">Permission</span>
        </div>
        <div class="back">
            <a href="{{route('admin.permissions.index')}}">
            <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
            </a>
        </div>
        <div class="create-role-form">
            <form action="{{route('admin.permissions.store')}}" method="post" >
                @csrf
                <div class="forms-input">
                    <label for="name">Permission Name</label>
                    <input type="text" name="name" class="name" >
                    <div class="error-container"> 
                        @error('name')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    <label for="group_name">Group Name</label>
                    @php
                        $group_names=['user','permission','role'];
                        
                    @endphp
                    
                   
                    <div class="select-container">
                        <select name="group_name" id="group_name">
                            <option selected="" disabled > Select Group</option>
                            @foreach ($group_names  as $item)
                                 <option value="{{$item}}" class="option" >{{$item}}</option>
                             @endforeach
                        </select>
                      </div>
                    
                    <div class="error-container"> 
                        @error('group_name')
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