@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@section('main')

<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bxs-time' ></i>
            <span class="text">Activity Log</span>
        </div>
        <div class="title">
            <span class="text">{{$type}}</span>
        </div>
        <div class="action-bar">
            <div class="left">
            {{-- <div class="pagination-select">
                <label for="pagination">Show:</label>
                <select name="pagination" id="pagination" onchange="changePage(this.value)">
                    <option value="10" {{ $selectedValue == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $selectedValue == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $selectedValue == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $selectedValue == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div> --}}
       
        @can('export_permission')
        
        <div class="action-button">
            <button class="export-permission" id="export-pdf-selected">PDF</button>
        </div>
       
        <div class="action-button">
            <button class="export-permission" id="export-selected">CSV</button>

        </div>
        @endcan 
       
        </div>
        <div class="right">
        <div class="search">
            <form action="{{route('admin.activity_log.search',$type)}}" method="get">
                <div class="input-container">
                    <input type="text" name="search" id="search" placeholder="Search here .....">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
        </div>
    </div>
    </div>
        
        
        
    
        
        
        <div class="all-permission-table">
            <table id="myTable">
                <thead>
                    <th><input type="checkbox" name="maincheckbox"></th>
                    <th>S.N.</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Request Type</th>
                    <th>IP Address</th>
                    <th>Geo Location</th>
                    <th>Message</th>
                    <th>URL</th>
                    <th>Changed ID</th>
                    <th>Data</th>
                    <th>Date/Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr>
                    <td></td>
                    <td>{{$log->id}}</td>
                    <td>{{$log->user_name}}</td>
                    <td>{{$log->email}}</td>
                    <td>{{$log->request_type}}</td>
                    <td>{{$log->ip_address}}</td>
                    <?php $geo_location=json_encode($log->geo_location) ?>
                    <td>{{$geo_location}}</td>
                    <td>{{$log->description}}</td>
                    <td>{{$log->url}}</td>
                    <td>{{$log->changed_id}}</td>
                    <?php $data=json_encode($log->data) ?>
                    <td>{{$data}}</td>
                    <td>{{$log->created_at}}</td>
                    <td class="all-button">
                        <div class="button-group">
                           
                                {{-- <a href="{{route('admin.activity_log.user.show',$user->id)}}"> --}}
                                    <a href="#">
                                    <button class="view"><i class='bx bx-show-alt' ></i>View </button>
                                </a>
                           
                           
                        </div>
                    </td>
                </tr>
                  
                   @endforeach
                    @if ($logs->isEmpty())
                        <tr>
                            <td colspan="5">No Log Found!</td>
                        </tr>
                    @endif
                        
                 
                </tbody>
               
            
            </table>
            
            {{-- <div class="your-custom-paginate">
                
                {{ $permissions->appends(['search' => request('search')])->links('vendor.pagination.custom') }}
            </div>
             --}}
        </div>
    </div>
  
    
</div>
<form id="selected-rows-form" action="{{ route('admin.permissions.exportselectedcsv') }}" method="POST">
    @csrf
    <input type="hidden" name="selectedRows" value="">
</form>
<form id="selected-rows-form-pdf" action="{{ route('admin.permissions.exportpdf') }}" method="POST">
    @csrf
    <input type="hidden" name="selectedRows" value="">
</form>


@endsection
{{-- Pagination --}}
<script>
    function changePage(selectedValue) {
        const currentUrl = window.location.href;
        const url = new URL(currentUrl);
        url.searchParams.set('perPage', selectedValue);
        window.location.href = url.toString();
    }
</script>
{{-- Check all  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the main checkbox and all the below checkboxes
        const mainCheckbox = document.querySelector('input[name="maincheckbox"]');
        const selectedCheckboxes = document.querySelectorAll('input[name="selectedRow[]"]');
    
        // Add an event listener to the main checkbox
        mainCheckbox.addEventListener('change', function() {
            // Get the checked state of the main checkbox
            const isChecked = mainCheckbox.checked;
    
            // Set the same checked state for all below checkboxes
            selectedCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the export button and the selected rows form
        const exportButton = document.getElementById('export-selected');
        const selectedRowsForm = document.getElementById('selected-rows-form');
    
        // Attach a click event listener to the export button
        exportButton.addEventListener('click', function(event) {
            event.preventDefault();
    
            // Find all the selected checkboxes
            const selectedCheckboxes = document.querySelectorAll('input[name="selectedRow[]"]:checked');
    
            // Extract the values of selected rows and set them as a comma-separated string
            const selectedRowValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value).join(',');
    
            // Set the selected rows as a hidden input value
            const selectedRowsInput = selectedRowsForm.querySelector('input[name="selectedRows"]');
            selectedRowsInput.value = selectedRowValues;
    
            // Submit the form to trigger the export action
            selectedRowsForm.submit();
        });
    });
    </script>
     {{-- Export Pdf --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the export button and the selected rows form
        const exportButton = document.getElementById('export-pdf-selected');
        const selectedRowsForm = document.getElementById('selected-rows-form-pdf');
    
        // Attach a click event listener to the export button
        exportButton.addEventListener('click', function(event) {
            event.preventDefault();
    
            // Find all the selected checkboxes
            const selectedCheckboxes = document.querySelectorAll('input[name="selectedRow[]"]:checked');
    
            // Extract the values of selected rows and set them as a comma-separated string
            const selectedRowValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value).join(',');
    
            // Set the selected rows as a hidden input value
            const selectedRowsInput = selectedRowsForm.querySelector('input[name="selectedRows"]');
            selectedRowsInput.value = selectedRowValues;
    
            // Submit the form to trigger the export action
            selectedRowsForm.submit();
        });
    });
    </script>
