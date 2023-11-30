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
       
        <div class="all-permission-table">
            <table>
                <thead>
                    
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Group Name</th>
                    
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                    <tr>
                        
                        <td>{{$permission->id}}</td>
                        <td>
                             {{$permission->name}}
                        </td>
                        <td>
                             {{$permission->group_name}}
                        </td>
                       
                    </tr>
                   
                       @endforeach
                    
                 
                </tbody>
            </table>
        </div>
  
    </div>
</div>
