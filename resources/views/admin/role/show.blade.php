@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<style>
    td:first-child {
      width: 130px !important;
  }
  th:first-child {
      width: 130px !important;
  }
  </style>
  <div class="back">
    <a href="{{route('admin.roles.index')}}">
    <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
    </a>
</div>
<div class="all-role-table">
    <table>
        <tbody>
            <tr>
                <th>S.N.</th>
                <td>{{ $role->id }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $role->name }}</td>
            </tr>
            <tr>
                <th>Permissions</th>
                <td>
                    @if ($role->permissions)
                        <div class="permission-container">
                            @foreach ($role->permissions as $role_permission)
                                <div class="permission">{{ $role_permission->name }}</div>
                            @endforeach
                        </div>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection