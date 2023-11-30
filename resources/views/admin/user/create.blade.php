@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bxs-user'></i>
            <span class="text">User</span>
        </div>
        <div class="back">
            <a href="{{route('admin.users.index')}}">
            <button class="back-button"><i class='bx bx-chevron-left'></i>Back</button>
            </a>
        </div>
        <div class="create-user-form">
            <form action="{{route('admin.users.store')}}" method="post" >
                @csrf
                <div class="forms-input">
                    {{-- Username --}}
                    <label for="name">User Name</label>
                    <input type="text" name="name" class="name" >
                    <div class="error-container"> 
                        @error('name')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <label for="email">Email</label>
                    <input type="email" name="email" class="email" >
                    <div class="error-container"> 
                        @error('email')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- password --}}
                    {{-- <label for="password">Password</label>
                    <input type="password" name="password" class="password" >
                    <div class="error-container"> 
                        @error('password')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div> --}}
                   <div class="password-field">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Password" name="password" id="password" class="password" required>
                        <i class='bx bx-hide eye-icon' id="eye"></i>
                    </div>
                    <input type="hidden" placeholder="Password" name="password_confirmation" id="password_confirmation" class="password" required>
                    @error('password')
                    <div class="error-container"> 
                        @error('password')
                        <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                    @enderror
                     
                    
                    {{-- Role --}}
                   
                    <label for="role">Role</label>
                    <button type="button" id="selectAllButton">Select All</button>
                    <button type="button" id="deselectAllButton">Deselect All</button>
                   <select name="role" id="role" multiple>
                       @foreach($roles as $role)
                           <option value="{{$role->name}}">{{$role->name}}</option>
                       @endforeach
                   </select>
                   
                   <div id="selectedRolesContainer" class="selected-roles-container"></div>

                   
                   <input type="hidden" name="selectedRoles[]" id="selectedRolesInput">
                   
                   <script>
                   const roleSelectElement = document.getElementById("role");
                   const selectedRolesContainer = document.getElementById("selectedRolesContainer");
                   const selectedRolesInput = document.getElementById("selectedRolesInput");
                   const selectedRoles = [];
                 

              


                    // Function to change the color of selected options
                    function optionValues() {
                        roleSelectElement.querySelectorAll("option").forEach(optionElement => {
                            if (selectedRoles.includes(optionElement.value)) {
                                optionElement.style.backgroundColor = '#C5c6d0'; 
                                optionElement.style.color = '#000'; 
                            } else {
                                optionElement.style.backgroundColor = ''; 
                                optionElement.style.color = '';
                            }
                        });
                    }
                   // Function to update the hidden input field
                   function updateSelectedRolesInput() {
                       selectedRolesInput.value = JSON.stringify(selectedRoles);
                       optionValues();
                   }
                   
                   // Function to populate the selected roles
                   function updateSelectedRolesContainer() {
                       selectedRolesContainer.innerHTML = "";
                   
                       selectedRoles.forEach(function(role) {
                           const roleElement = document.createElement("div");
                           roleElement.classList.add("selected-role");
                           roleElement.innerHTML = role + '<span class="remove-role">✕</span>';
                   
                           roleElement.querySelector(".remove-role").addEventListener("click", function() {
                               const roleValue = role;
                               const index = selectedRoles.indexOf(roleValue);
                               if (index > -1) {
                                   selectedRoles.splice(index, 1);
                               }
                               roleElement.remove();
                               updateSelectedRolesInput();
                               optionValues();
                           });
                   
                           selectedRolesContainer.appendChild(roleElement);
                       });
                   
                       updateSelectedRolesInput();
                       optionValues();
                   }
                   
                  
                   
                   roleSelectElement.addEventListener("change", function(event) {
                       const selectedValues = Array.from(event.target.selectedOptions).map(option => option.value);
                   
                       selectedValues.forEach(function(roleValue) {
                           if (!selectedRoles.includes(roleValue)) {
                               selectedRoles.push(roleValue);
                   
                               const roleElement = document.createElement("div");
                               roleElement.classList.add("selected-role");
                               roleElement.innerHTML = roleValue + '<span class="remove-role">✕</span>';
                   
                               roleElement.querySelector(".remove-role").addEventListener("click", function() {
                                   const index = selectedRoles.indexOf(roleValue);
                                   if (index > -1) {
                                       selectedRoles.splice(index, 1);
                                   }
                                   roleElement.remove();
                                   updateSelectedRolesInput();
                                   optionValues();
                               });
                   
                               selectedRolesContainer.appendChild(roleElement);
                           }
                       });
                   
                       updateSelectedRolesInput();
                       optionValues();
                   });
                    const selectAllButton = document.getElementById("selectAllButton");
                    const deselectAllButton = document.getElementById("deselectAllButton");

                    selectAllButton.addEventListener("click", function() {
                        Array.from(roleSelectElement.options).forEach(option => option.selected = true);
                        selectedRoles.length = 0; // Clear the existing selected options
                        selectedRoles.push(...Array.from(roleSelectElement.options).map(option => option.value)); // Push all option values into the array
                        updateSelectedRolesContainer();
                        updateSelectedRolesInput();
                        optionValues();
                    });

                    deselectAllButton.addEventListener("click", function() {
                        Array.from(roleSelectElement.options).forEach(option => option.selected = false);
                        selectedRoles.length = 0;
                        updateSelectedRolesContainer();
                        updateSelectedRolesInput();
                        optionValues();
                    });
                     // Call the function to populate the selected roles
                   updateSelectedRolesContainer();
                    optionValues();
                   </script>
                   

                </div>
                
                
                <button type="submit" class="create-btn">Create</button>
            </form>
        </div>
        
   
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const eyeIcon = document.getElementById("eye");
    const passwordInput = document.querySelector("input[type='password']");
    
    if (passwordInput && eyeIcon) {
        eyeIcon.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    }
    else {
        console.log("Elements not found");
    }
});
</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');

    passwordInput.addEventListener('input', function() {
        passwordConfirmationInput.value = passwordInput.value;
    });
});

</script>