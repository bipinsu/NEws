<style>
    /* Regular styles for screen display */
.content {
    margin: 0;
    padding: 0;
   
  
    font-family: Arial, sans-serif;
    /* Add other regular styles here */
}

.overview {
    
    background-color: #fff;
    /* border: 1px solid #ccc; */
    /* Add other regular styles here */
}

h1 {
    font-size: 24px;
    color: #333;
    /* Add other regular styles here */
}

table {
    width: 100%;
    h
    border-collapse: collapse;
    /* Add other regular table styles here */
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    /* Add other regular table cell styles here */
}




</style>
<div class="content">
    <div class="overview">
        
        {{-- @endcan --}}
        <div class="all-user-table">
            <table>
                <thead>
                    
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                   
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                       
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>
                            {{-- <div class="role-container">
                                Admin
                            </div> --}}
                            @if($user->roles)
                            <div class="role-container">
                                @foreach($user->roles as $user_roles)
                                    <div class="roles">{{$user_roles->name}}</div>
                                @endforeach
                            </div>
                           
                            @endif
                        </td>
                        <td>{{$user->email}}</td>
                        
                    </tr>
                  @endforeach
                   
                       
                    
                 
                </tbody>
            </table>
        </div>
    </div>
</div>



    