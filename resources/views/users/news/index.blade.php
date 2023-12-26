@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">
<link rel="stylesheet" href="/css/admin/popupnews.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@section('main')
    <div class="content">
        <div class="overview">
            <div class="title">
                <i class='bx bx-customize'></i>
                <span class="text">News</span>
            </div>
            {{-- @can('create_navcontent') --}}
            <div class="create">
                <button class="create-permission" onclick="showPopup()">Create News</button>

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
                        <form action="{{ route('admin.news.search') }}" method="get">
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
                        <th>Nav Heading</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        @foreach ($news as $new)
                            <tr>
                                <td> <input type="checkbox" name="selectedRow[]" value="{{ $new->id }}"></td>
                                <td>{{ $new->id }}</td>
                                <td>
                                    {{ $new->title }}
                                </td>
                                <td>
                                    {{ $new->nav_headings_id }}
                                </td>
                                <td class="all-button">
                                    <div class="button-group">
                                        {{-- @can('view_new') --}}

                                        <button class="view" onclick="showViewPopup({{ $new->id }}, 'view')">
                                            <i class='bx bx-show-alt'></i>View
                                        </button>

                                        {{-- @endcan --}}
                                        {{-- @can('edit_new') --}}
                                        <button class="edit" onclick="showEditPopup({{ $new->id }}, 'edit')">
                                            <i class='bx bxs-edit'></i>Edit
                                        </button>
                                        {{-- @endcan --}}
                                        {{-- @can('delete_new') --}}
                                        <form action="{{ route('admin.news.destroy', $new->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete"><i
                                                    class='bx bxs-trash-alt'></i>Delete</button>
                                        </form>
                                        {{-- @endcan --}}




                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($news->isEmpty())
                            <tr>
                                <td colspan="5">No Nav Heading Found!</td>
                            </tr>
                        @endif


                    </tbody>


                </table>

                <div class="your-custom-paginate">

                    {{ $news->appends(['search' => request('search')])->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>


    </div>
    <form id="selected-rows-form" action="{{ route('admin.news.exportselectedcsv') }}" method="POST">
        @csrf
        <input type="hidden" name="selectedRows" value="">
    </form>
    <form id="selected-rows-form-pdf" action="{{ route('admin.news.exportpdf') }}" method="POST">
        @csrf
        <input type="hidden" name="selectedRows" value="">
    </form>
    <form id="delete-selected-form" action="{{ route('admin.news.deleteSelected') }}" method="POST">
        @csrf
        <input type="hidden" name="selectedRows" value="">
    </form>

    {{-- Popup --}}
    {{-- Create --}}
    <div id="overlay" class="overlay" onclick="closePopup()"></div>
    <div id="popup" class="popup">
        <div class="close-button" onclick="closePopup()"><span>X</span></div>
        <form action="{{ route('admin.news.store') }}" method="POST" id="newsForm" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2>Add News</h2>

            <label for="nav_headings_id">
                <strong>Nav Heading</strong>
            </label>
            <select name="nav_headings_id" id="nav_heading_id">
                <option value="" disabled selected>Select a heading</option>
                @foreach ($nav_heading as $heading)
                    <option value="{{ $heading->id }}"> {{ $heading->name }}</option>
                @endforeach
            </select>
            <label for="nav_sub_headings_id">
                <strong>Nav Sub-Heading</strong>
            </label>
            <select name="nav_sub_headings_id" id="nav_sub_heading_id">

            </select>
            <label for="title">
                <strong>Title</strong>
            </label>
            <input type="text" name="title" placeholder="Title">

            <label for="description">
                <strong>Description</strong>
            </label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            {{-- <label for="image">
                <strong>Image</strong>
            </label> --}}
            {{-- <input type="file" name="images[]" multiple> --}}
            <div class="upload__box">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p>Upload images</p>
                        <input type="file" multiple="" name="images[]" id="file_images" data-max_length="20"
                            class="upload__inputfile">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>



            <button type="submit" class="btn">Submit</button>

        </form>
    </div>
    {{-- Edit --}}
    <div id="overlayEdit" class="overlayEdit" onclick="closeEditPopup()"></div>
    <div id="popupEdit" class="popupEdit">
        <div class="close-button" onclick="closeEditPopup()"><span>X</span></div>
        <form action="{{ route('admin.news.update', 'news') }}" method="POST" id="newsForm"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="nav_heading_id">
                <strong>Nav Heading</strong>
            </label>
            <select name="nav_heading_id" id="nav_heading_idEdit">
                <option value="" disabled selected>Select a heading</option>
                @foreach ($nav_heading as $heading)
                    <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                @endforeach
            </select>

            <label for="nav_sub_heading_id">
                <strong>Nav Sub-Heading</strong>
            </label>
            <select name="nav_sub_heading_id" id="nav_sub_heading_idEdit">
                <option value="" disabled selected>Select a heading</option>
                @foreach ($nav_sub_heading as $heading)
                    <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                @endforeach
            </select>

            <label for="name">
                <strong>Title</strong>
            </label>
            <input type="text" name="name" id="nameEdit" placeholder="Title">

            <label for="description">
                <strong>Description</strong>
            </label>
            <textarea name="description" id="descriptionEdit" cols="30" rows="10"></textarea>

            <div class="upload__box">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p>Upload images</p>
                        <input type="file" multiple="" name="images[]" id="file_images_edit" data-max_length="20"
                            class="upload__inputfile">
                    </label>
                </div>
                <div class="upload__img-wrap_edit"></div>
            </div>
            <div class="previous_imgs"></div>

            <button type="submit" class="btn">Update</button>
        </form>
    </div>
    {{-- View --}}
    <div id="overlayView" class="overlayView" onclick="closeViewPopup()"></div>
    <div id="popupView" class="popupView">
        <div class="close-button" onclick="closeViewPopup()"><span>X</span></div>
        <h2>View News</h2>
        <span class="content">

            <h3><strong>S.N</strong>:</h3>
            <h4><span id="SNView"></span></h4>
        </span>
        <span class="content">

            <h3><strong>Collateral</strong>:</h3>
            <h4><span id="collateralView"></span></h4>
        </span>
    </div>

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
{{-- popup --}}
{{-- create --}}
<script>
    function showPopup() {
        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");
        overlay.style.display = "block";
        popup.style.display = "block";
    }

    function closePopup() {
        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");

        overlay.style.display = "none";
        popup.style.display = "none";
    }
</script>
{{-- View --}}
<script>
    function showViewPopup(basel_codesId) {
        // Use AJAX to fetch the basel-codes data from the server
        $.ajax({
            url: '/admin/get-basel-codes/' + basel_codesId, // Replace with your actual route
            type: 'GET',
            success: function(response) {


                $('#SNView').text(response.SN);
                $('#collateralView').text(response.name);
                // Show the modal
                $('#popupView').show();
                $('#overlayView').show();
            },
            error: function(error) {
                console.error('Error fetching role data:', error);
            }
        });
    }

    function closeViewPopup() {
        // Close the modal
        $('#popupView').hide();
        $('#overlayView').hide();
    }
</script>



{{-- Sub heading --}}
<script>
    $(document).ready(function() {
        $('#nav_heading_id').on('change', function() {
            var headingId = $(this).val();

            // Make an AJAX request to fetch subheadings based on the selected heading
            $.ajax({
                url: '/admin/get-subheadings/' + headingId, // Replace with the actual route
                type: 'GET',
                success: function(data) {
                    // Clear existing subheading options
                    $('#nav_sub_heading_id').empty();

                    // Populate subheading options
                    $.each(data, function(key, value) {
                        $('#nav_sub_heading_id').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
{{-- image --}}

<script>
    jQuery(document).ready(function() {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];
        var iterator = 0;

        $('.upload__inputfile').each(function() {
            $(this).on('change', function(e) {
                imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                var maxLength = $(this).attr('data-max_length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                filesArr.forEach(function(f, index) {

                    if (!f.type.match('image.*')) {
                        return;
                    }

                    if (imgArray.length >= maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);


                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result + ")' data-number='" + iterator +
                                "' data-file='" + f
                                .name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                });
            });
        });

        $('body').on('click', ".upload__img-close", function(e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1); // Remove the image from the array
                    break;
                }
            }
            $(this).parent().parent().remove(); // Remove the image from the DOM
        });
        $('#newsForm').on('submit', function(e) {
            //  e.preventDefault(); // Prevent the default form submission

            const file_images = document.getElementById('file_images');
            var fileList = new DataTransfer();

            // Add all files from imgArray to the FileList object
            imgArray.forEach(function(file) {
                fileList.items.add(file);
            });

            // Set the 'files' property of the file input element to the FileList object
            file_images.files = fileList.files;
        });



    }
</script>
{{-- edit --}}


<script>
    function showEditPopup(newsId) {
      // Use AJAX to fetch the news data from the server
      $.ajax({
          url: '/admin/get-news/' + newsId, // Replace with your actual route
          type: 'GET',
          success: function(response) {
              // Set the selected option based on the nav_heading_id value
              $('#nav_heading_idEdit').val(response.nav_headings_id);
              $('#nav_sub_heading_idEdit').val(response.nav_sub_headings_id);

              // Set other form values
              $('#nameEdit').val(response.title);
              $('#descriptionEdit').val(response.description);

              if (response.images) {
                console.log(response.images);
                var imgContainer = $('.previous_imgs');
                imgContainer.empty();
                response.images.forEach(function(image) {
                var img = $('<img>').attr('src', "/storage/" + image.image_path).attr('alt', 'Image');
                imgContainer.append(img);
                });
            }

              // Show the modal
              $('#popupEdit').show();
              $('#overlayEdit').show();
          },
          error: function(error) {
              console.error('Error fetching news data:', error);
          }
      });
    }

        function closeEditPopup() {
            // Close the modal and reset form values
            $('#popupEdit').hide();
            $('#overlayEdit').hide();
            $('#newsForm')[0].reset();
        }
    </script>
<script>
jQuery(document).ready(function() {
 ImgUploadEdit();
});

function ImgUploadEdit() {
 var imgWrap = "";
 var imgArray = [];
 var iterator = 0;

 $('#file_images_edit').each(function() {
     $(this).on('change', function(e) {
         imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap_edit');
         var maxLength = $(this).attr('data-max_length');

         var files = e.target.files;
         var filesArr = Array.prototype.slice.call(files);
         filesArr.forEach(function(f, index) {

             if (!f.type.match('image.*')) {
               return;
             }

             if (imgArray.length >= maxLength) {
               return false;
             } else {
               imgArray.push(f);

               var reader = new FileReader();
               reader.onload = function(e) {
                 var html =
                     "<div class='upload__img-box'><div style='background-image: url(" +
                     e.target.result + ")' data-number='" + iterator + "' data-file='" + f
                     .name +
                     "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                 imgWrap.append(html);
                 iterator++;
               }
               reader.readAsDataURL(f);
             }
         });
     });
 });

 $('body').on('click', ".upload__img-close", function(e) {
     var file = $(this).parent().data("file");
     for (var i = 0; i < imgArray.length; i++) {
         if (imgArray[i].name === file) {
             imgArray.splice(i, 1); // Remove the image from the array
             break;
         }
     }
     $(this).parent().parent().remove(); // Remove the image from the DOM
 });

 $('#newsForm').on('submit', function(e) {
   e.preventDefault(); // Prevent the default form submission

   const file_images = document.getElementById('file_images_edit');
   var fileList = new DataTransfer();

   // Add all files from imgArray to the FileList object
   imgArray.forEach(function(file) {
     fileList.items.add(file);
   });

   // Set the 'files' property of the file input element to the FileList object
   file_images.files = fileList.files;

   // Now you can submit the form
   this.submit();
 });
}
</script>
