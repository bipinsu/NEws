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
        
        <h1>{{$title}}</h1>
        <p>{{$date}}</p>

        <div class="all-role-table">
            <table>
                <thead>
                    
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Permissions</th> 
                   
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        
                   
                    <tr>
                       
                        <td>{{$role->id}}</td>
                        <td>
                           {{$role->name}}
                        </td>
                        
                        <td>
                            @if($role->permissions)
                                <div class="permission-container">
                                    @foreach($role->permissions as $role_permission)
                                        <div class="permission">{{$role_permission->name}}</div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                      
                    </tr>
                    @endforeach
                       
                    
                 
                </tbody>
            </table>
        </div>
   
    </div>
</div>
