@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@section('main')
    <div class="content">
        <div class="overview">
            <div class="title">
                <i class='bx bx-customize'></i>
                <span class="text">Nav Content</span>
            </div>
            {{-- @can('create_navcontent') --}}
            <div class="create">

                <a href="{{ route('admin.nav_contents.create') }}">
                    <button class="create-permission">Create Nav Content</button>
                </a>
            </div>
            {{-- @endcan --}}
            <div class="action-bar">
                <div class="left">
                    <div class="pagination-select">
                        <label for="pagination">Show:</label>
                        <select name="pagination" id="pagination" onchange="changePage(this.value)">
                            <option value="10" {{ $selectedValue == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $selectedValue == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $selectedValue == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $selectedValue == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    @can('import_permission')
                        <div class="action-button">
                            <a href="{{ route('admin.nav_contents.import') }}">

                                <button class="import-permission">Import CSV</button>
                            </a>
                        </div>
                    @endcan
                    @can('export_permission')
                        <div class="action-button">

                            <button class="export-permission" id="export-pdf-selected">PDF</button>

                        </div>

                        <div class="action-button">


                            <button class="export-permission" id="export-selected">CSV</button>


                        </div>
                    @endcan
                    @can('delete_permission')
                        <div class="action-button">
                            <button class="delete-role" id="delete-selected-button"><i class='bx bxs-trash-alt'></i>Delete
                                Selected</button>
                        </div>
                    @endcan
                </div>
                <div class="right">
                    <div class="search">
                        <form action="{{ route('admin.nav_contents.search') }}" method="get">
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
                        <th>Title</th>
                        <th>Group Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        @foreach ($nav_headings as $nav_heading)
                            <tr>
                                <td> <input type="checkbox" name="selectedRow[]" value="{{ $nav_heading->id }}"></td>
                                <td>{{ $nav_heading->id }}</td>
                                <td>
                                    {{ $nav_heading->name }}
                                </td>
                                <td>
                                    {{ $nav_heading->group_name }}
                                </td>
                                <td class="all-button">
                                    <div class="button-group">
                                        @can('view_nav_heading')
                                            <a href="{{ route('admin.nav_contents.show', $nav_heading->id) }}">
                                                <button class="view"><i class='bx bx-show-alt'></i>View </button>
                                            </a>
                                        @endcan
                                        @can('edit_nav_heading')
                                            <a href="{{ route('admin.nav_contents.edit', $nav_heading->id) }}">
                                                <button class="edit"><i class='bx bxs-edit'></i>Edit</button>
                                            </a>
                                        @endcan
                                        @can('delete_nav_heading')
                                            <form action="{{ route('admin.nav_contents.destroy', $nav_heading->id) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete"><i
                                                        class='bx bxs-trash-alt'></i>Delete</button>
                                            </form>
                                        @endcan




                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($nav_headings->isEmpty())
                            <tr>
                                <td colspan="5">No Nav Heading Found!</td>
                            </tr>
                        @endif


                    </tbody>


                </table>

                <div class="your-custom-paginate">

                    {{ $nav_headings->appends(['search' => request('search')])->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>


    </div>
    <form id="selected-rows-form" action="{{ route('admin.nav_contents.exportselectedcsv') }}" method="POST">
        @csrf
        <input type="hidden" name="selectedRows" value="">
    </form>
    <form id="selected-rows-form-pdf" action="{{ route('admin.nav_contents.exportpdf') }}" method="POST">
        @csrf
        <input type="hidden" name="selectedRows" value="">
    </form>
    <form id="delete-selected-form" action="{{ route('admin.nav_contents.deleteSelected') }}" method="POST">
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
{{-- Export CSV --}}
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
            const selectedRowValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value)
                .join(',');

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
            const selectedRowValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value)
                .join(',');

            // Set the selected rows as a hidden input value
            const selectedRowsInput = selectedRowsForm.querySelector('input[name="selectedRows"]');
            selectedRowsInput.value = selectedRowValues;

            // Submit the form to trigger the export action
            selectedRowsForm.submit();
        });
    });
</script>
{{-- Deleted selected --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the export button and the selected rows form
        const deleteSelectedButton = document.getElementById('delete-selected-button');
        const selectedRowsForm = document.getElementById('delete-selected-form');

        // Attach a click event listener to the export button
        deleteSelectedButton.addEventListener('click', function(event) {
            event.preventDefault();

            // Find all the selected checkboxes
            const selectedCheckboxes = document.querySelectorAll('input[name="selectedRow[]"]:checked');

            // Extract the values of selected rows and set them as a comma-separated string
            const selectedRowValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value)
                .join(',');

            // Set the selected rows as a hidden input value
            const selectedRowsInput = selectedRowsForm.querySelector('input[name="selectedRows"]');
            selectedRowsInput.value = selectedRowValues;

            // Submit the form to trigger the export action
            selectedRowsForm.submit();
        });
    });
</script>
