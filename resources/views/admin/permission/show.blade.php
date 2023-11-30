@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="back">
    <a href="{{route('admin.permissions.index')}}">
    <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
    </a>
</div>
<style>
    td:first-child {
      width: 130px !important;
  }
  th:first-child {
      width: 130px !important;
  }
  </style>
<div class="all-permission-table">
    <table>
        <tbody>
            <tr>
                <th>S.N.</th>
                <td>{{ $permission->id }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $permission->name }}</td>
            </tr>
            <tr>
                <th>Group Name</th>
                <td>{{ $permission->group_name }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection