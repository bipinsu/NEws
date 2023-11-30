
<style>
  td:first-child {
    width: 130px !important;
}
th:first-child {
    width: 130px !important;
}
</style>
@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="back">
    <a href="{{route('admin.users.index')}}">
    <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
    </a>
</div>
<div class="all-user-table">
    <table>
        <tbody>
            <tr>
                <th>S.N.</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>
                    @if ($user->roles)
                        <div class="role-container">
                            @foreach ($user->roles as $user_role)
                                <div class="roles">{{ $user_role->name }}</div>
                            @endforeach
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Permission</th>
                <td>
                    @if ($user->roles)
                        @foreach ($user->roles as $user_role)
                            @if ($user_role->permissions)
                                <div class="permission-container">
                                    @foreach ($user_role->permissions as $role_permission)
                                        <div class="permission">{{ $role_permission->name }}</div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
