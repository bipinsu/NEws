const forms= document.querySelector(".forms"),
      pwShowHide= document.querySelectorAll(".eye-icon");
pwShowHide.forEach(eyeIcon =>{
    eyeIcon.addEventListener("click",() => {
        let pwField =eyeIcon.parentElement.parentElement.querySelectorAll(".password");
        pwField.forEach(password =>{
            if(password.type ==="password"){
                password.type="text";
                eyeIcon.classList.replace("bx-hide","bx-show");
                return;
            }
            password.type="password";
            eyeIcon.classList.replace("bx-show","bx-hide");
        })
    })
})
// links.forEach(link => {
//     link.addEventListener("click", e => {
//       e.preventDefault();
//       forms.classList.toggle("show-signup");
  
//       const signupForm = document.querySelector(".form.signup");
//       const loginForm = document.querySelector(".form.login");
//       const signupInputs = signupForm.querySelectorAll("input");
//       const loginInputs = loginForm.querySelectorAll("input");
  
//       if (forms.classList.contains("show-signup")) {
//         signupInputs.forEach(input => {
//           input.required = true;
//         });
  
//         loginInputs.forEach(input => {
//           input.required = false;
//         });
//       } else {
//         signupInputs.forEach(input => {
//           input.required = false;
//         });
  
//         loginInputs.forEach(input => {
//           input.required = true;
//         });
//       }
//     });
//   });
  