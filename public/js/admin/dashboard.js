document.addEventListener("DOMContentLoaded", function() {
    const body = document.querySelector("body");
    const modeToggle = body.querySelector(".mode-toggle");
    const sidebarToggle = body.querySelector(".sidebar-toggle");
    const sidebar = body.querySelector("nav");
  

  
    modeToggle.addEventListener("click", () => {
      body.classList.toggle("dark");
      if (body.classList.contains("dark")) {
        localStorage.setItem("mode", "dark");
      } else {
        localStorage.setItem("mode", "light");
      }
    });
  
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
      if (sidebar.classList.contains("close")) {
        localStorage.setItem("status", "close");
      } else {
        localStorage.setItem("status", "open");
      }
    });
  
  });
  

