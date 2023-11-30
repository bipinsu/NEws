@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
@section('main')
<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bxs-briefcase'></i>
            <span class="text">Role</span>
        </div>
        <div class="back">
            <a href="{{route('admin.roles.index')}}">
            <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
            </a>
        </div>
        <div class="create-role-form">
            {{-- <h2>Role Permission</h2> --}}
            {{-- @if($role->permissions)
                @foreach($role->permissions as $role_permission)
                    <span>{{$role_permission->name}}</span>
                @endforeach
            @endif --}}

            <form action="{{route('admin.roles.update',$role)}}" method="post" >
                @csrf
                @method('PUT')
                <div class="forms-input">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" class="name" value="{{$role->name}}" >
                    
                    <div class="error-container"> 
                        @error('name')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                    <label for="permission">Permission</label>
                   
                   
                    
                    {{-- <button type="button" id="selectAllButton">Select All</button>
                    <button type="button" id="deselectAllButton">Deselect All</button>
                    <select name="permission" id="permission" autocomplete="permission-name" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{$permission->name}}">{{$permission->name}}</option>
                        @endforeach
                    </select>
                    
                    
                        <div id="selectedOptionsContainer">
                            
                        </div>
                   
                    <input type="hidden" name="selectedOptions[]" id="selectedOptionsInput"> --}}
                    <div class="all_permissions">
                        <input type="checkbox" name="all_permission" value="all_permission" id="all_permission">
                        <label for="all_permission">All Permission</label>
                    </div>
                    <hr class="line">
                    
                      
                    @foreach ($permission_groups as $permission_group) 
                    <div class="custom-container">
                      <div class="custom-row">
                        <div class="custom-col-3">
                          <div class="custom-checkbox">
                            <input type="checkbox" class="custom-checkbox-input group-checkbox" 
                            {{App\Models\User::roleHasPermissions($role , $permissions) ? 'checked':''}}
                              value="{{ $permission_group->group_name }}"
                              name="{{ $permission_group->group_name }}">
                            <label class="custom-checkbox-label" for="{{ $permission_group->group_name }}">
                              {{ $permission_group->group_name }}
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="custom-row custom-permissions">
                        <?php
                          $permissions = App\Models\User::getpermissionByGroupName($permission_group->group_name);
                        ?>
                         @foreach ($permissions as $permission) 
                          <div class="custom-col-3 permission-indent">
                            <div class="custom-checkbox">
                              <input type="checkbox" class="custom-checkbox-input permission-checkbox" id="{{ $permission->name }}"
                                value="{{ $permission->name}}"
                                name="permission[]"
                                {{$role->hasPermissionTo($permission->name) ? 'checked':''}}>
                              <label class="custom-checkbox-label" for="{{ $permission->name }}">
                                {{ $permission->name }}
                              </label>
                            </div>
                          </div>
                          @endforeach
                      </div>
                    </div>
                  @endforeach
                    
                    
                    
                    

            
            
                
                
                
                <button type="submit" class="create-btn">Update</button>
            </form>
        </div>
        
   
    </div>
</div>
<script>
    $(document).ready(function() {
function updateGroupCheckbox(groupContainer) {
  var groupCheckbox = groupContainer.find('.group-checkbox');
  var permissionsContainer = groupContainer.find('.permission-checkbox');
  groupCheckbox.prop('checked', permissionsContainer.not(':not(:checked)').length === 0);
}

function updateAllPermissionCheckbox() {
  var allPermissionsChecked = true;
  $('.permission-checkbox').each(function() {
    if (!$(this).is(':checked')) {
      allPermissionsChecked = false;
      return false; // Break the loop when an unchecked permission is found
    }
  });
  $('#all_permission').prop("checked", allPermissionsChecked);
}

$('#all_permission').click(function() {
  var isChecked = $(this).is(':checked');
  $('input[type="checkbox"]').prop("checked", isChecked);
});

$('.group-checkbox').click(function() {
  var groupContainer = $(this).closest('.custom-container');
  var permissionsContainer = groupContainer.find('.permission-checkbox');
  permissionsContainer.prop("checked", $(this).is(':checked'));
  updateAllPermissionCheckbox();
});

$('.permission-checkbox').click(function() {
  var permissionCheckbox = $(this);
  var groupContainer = permissionCheckbox.closest('.custom-container');
  updateAllPermissionCheckbox();
  updateGroupCheckbox(groupContainer);

  if (!permissionCheckbox.is(':checked')) {
    groupContainer.find('.group-checkbox').prop("checked", false);
  } else {
    var allPermissionsChecked = true;
    groupContainer.find('.permission-checkbox').each(function() {
      if (!$(this).is(':checked')) {
        allPermissionsChecked = false;
        return false; // Break the loop when an unchecked permission is found
      }
    });
    if (allPermissionsChecked) {
      groupContainer.find('.group-checkbox').prop("checked", true);
    }
  }
});
});

  </script>
             {{-- <script>

                const selectElement = document.getElementById("permission");
                const selectedOptionsContainer = document.getElementById("selectedOptionsContainer");
                const selectedOptionsInput = document.getElementById("selectedOptionsInput");
                const selectedOptions = [];
                
                // Populate selectedOptions from PHP array
                @foreach($role->permissions as $role_permission)
                    selectedOptions.push("{{ $role_permission->name }}");
                @endforeach
                
                // Function to change the color of selected options
                function optionValues() {
                    selectElement.querySelectorAll("option").forEach(optionElement => {
                        if (selectedOptions.includes(optionElement.value)) {
                            optionElement.style.backgroundColor = '#C5c6d0'; // Set background color to gray
                            optionElement.style.color = '#000'; // Set text color to black
                        } else {
                            optionElement.style.backgroundColor = ''; // Reset background color
                            optionElement.style.color = ''; // Reset text color
                        }
                    });
                }
                
                // Function to update the hidden input field
                function updateSelectedOptionsInput() {
                    selectedOptionsInput.value = JSON.stringify(selectedOptions);
                    optionValues();
                }
                
                // Function to populate the selected permissions
                function updateSelectedOptionsContainer() {
                    selectedOptionsContainer.innerHTML = "";
                
                    selectedOptions.forEach(function(option) {
                        const optionElement = document.createElement("div");
                        optionElement.classList.add("selected-option");
                        optionElement.innerHTML = option + '<span class="remove-option">✕</span>';
                
                        optionElement.querySelector(".remove-option").addEventListener("click", function() {
                            const optionValue = option;
                            const index = selectedOptions.indexOf(optionValue);
                            if (index > -1) {
                                selectedOptions.splice(index, 1);
                            }
                            optionElement.remove();
                            updateSelectedOptionsInput();
                            optionValues();
                        });
                
                        selectedOptionsContainer.appendChild(optionElement);
                    });
                
                    updateSelectedOptionsInput();
                    optionValues();
                }
                
                // Call the function to populate the selected permissions
                updateSelectedOptionsContainer();
                
                selectElement.addEventListener("change", function(event) {
                    const selectedValues = Array.from(event.target.selectedOptions).map(option => option.value);
                
                    selectedValues.forEach(function(optionValue) {
                        if (!selectedOptions.includes(optionValue)) {
                            selectedOptions.push(optionValue);
                
                            const optionElement = document.createElement("div");
                            optionElement.classList.add("selected-option");
                            optionElement.innerHTML = optionValue + '<span class="remove-option">✕</span>';
                
                            optionElement.querySelector(".remove-option").addEventListener("click", function() {
                                 // Change optionValue to another variable name
                                const index = selectedOptions.indexOf(optionValue);
                                if (index > -1) {
                                    selectedOptions.splice(index, 1);
                                }
                                optionElement.remove();
                                updateSelectedOptionsInput();
                                optionValues();
                            });
                
                            selectedOptionsContainer.appendChild(optionElement);
                        }
                    });
                
                    updateSelectedOptionsInput();
                    optionValues();
                });
                
                const selectAllButton = document.getElementById("selectAllButton");
                const deselectAllButton = document.getElementById("deselectAllButton");
                
                selectAllButton.addEventListener("click", function() {
                    Array.from(selectElement.options).forEach(option => option.selected = true);
                    selectedOptions.length = 0; // Clear the existing selected options
                    selectedOptions.push(...Array.from(selectElement.options).map(option => option.value)); // Push all option values into the array
                    updateSelectedOptionsContainer();
                    updateSelectedOptionsInput();
                    optionValues();
                });
                
                deselectAllButton.addEventListener("click", function() {
                    Array.from(selectElement.options).forEach(option => option.selected = false);
                    selectedOptions.length = 0;
                    updateSelectedOptionsContainer();
                    updateSelectedOptionsInput();
                    optionValues();
                });
                
                optionValues();
                
                </script> --}}
                
                          
@endsection