<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    {{-- Boxicon CSS --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/admin/dashboardlayout.css">
    {{-- JS --}}
    <script defer  src="/js/admin/dashboard.js"></script>


</head>
<body >

    <script>
        (function() {
            const body = document.querySelector("body");
            let getMode = localStorage.getItem("mode");
            if (getMode && getMode === "dark") {
                body.classList.add("dark");
            } else {
                body.classList.remove("dark");
            }

        })();
    </script>




    <nav>
        {{-- Nav logo --}}
        <div class="logo">
            {{-- nav logo --}}
            <div class="logo-image">
                <img src="{{asset('logo/logo.png')}}" alt="">
            </div>
            {{-- Name of website --}}
            <span class="logo-name">Broker Free</span>
        </div>
        {{-- sidebar --}}
        <div class="menu-items">
            {{-- links of sidebar --}}
            <ul class="nav-links">
                {{-- dashboard --}}
                <li>
                    <a href="/admin/dashboard">
                        {{-- <i class='bx bxs-home'></i> --}}
                        <i class='bx bx-tachometer'></i>
                        <span class="link-name">Dashboard</span>
                    </a>
                </li>
                <li  id="user_mgmt">

                    <a>
                        <i class='bx bxs-id-card'></i>
                        <span class="link-name">User Management</span>
                        <i class='bx bx-chevron-left arrow'></i>
                    </a>
                    <ul class="sub-menu" id="user_sub_menu">
                        {{-- Users --}}
                        @can('view_user')
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                <i class='bx bxs-user'></i>
                                <span class="link-name">User</span>
                            </a>
                        </li>
                    @endcan
                    {{-- Permission --}}
                    @can('view_permission')
                        <li>
                            <a href="{{ route('admin.permissions.index') }}">
                                <i class='bx bxs-lock-open'></i>
                                <span class="link-name">Permission</span>
                            </a>
                        </li>
                    @endcan
                    {{-- Role --}}
                    @can('view_role')
                        <li>
                            <a href="{{ route('admin.roles.index') }}">
                                <i class='bx bxs-briefcase'></i>
                                <span class="link-name">Role</span>
                            </a>
                        </li>
                    @endcan
                    </ul>


                </li>
                <li>
                    <a href="{{ route('admin.activity_log.index') }}">
                        <i class='bx bxs-time' ></i>
                        <span class="link-name">Activity Log</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bx-customize'></i>
                        <span class="link-name">Nav Content</span>
                    </a>
                </li>
            </ul>

            <ul class="logout-mode">
                {{-- logout --}}
                <li>
                    <a href="{{ route('logout') }}">
                        <i class='bx bx-log-out'></i>
                        <span class="link-name">Logout</span>
                    </a>
                </li>
                {{-- darkmode lightmode --}}
                <li class="mode">
                    <a href="#">
                        <i class='bx bx-moon'></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        (function() {
            const sidebarToggle = document.querySelector(".sidebar-toggle");
            const sidebar = document.querySelector("nav");

            // Apply the sidebar status from localStorage
            let getStatus = localStorage.getItem("status");
            if (getStatus === "close") {
                sidebar.classList.add("close");
            } else if (getStatus === "open") {
                sidebar.classList.remove("close");
            }


        })();
    </script>
      <script>
        // JavaScript to toggle the sub-menu when "User Management" is clicked
        const userManagementItem = document.getElementById('user_mgmt');
        const subMenu = document.getElementById("user_sub_menu");
        const arrow = userManagementItem.querySelector('.arrow');

        userManagementItem.addEventListener("click", () => {
            subMenu.classList.toggle("show");
            arrow.classList.toggle('rotate');
        });
    </script>
    <section class="dashboard">
        <div class="top">
            <i class='bx bx-menu sidebar-toggle' ></i>
            {{-- <div class="search-box" >
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search here .....">
            </div> --}}
            <div class="user-detail">
                {{-- <img src="{{asset('profile/profile.jpg')}}" alt="no img"> --}}
                <span class="user-name">Welcome {{auth()->user()->name}}</span>
            </div>

        </div>
    </section>
    @include('layout.toastr')
    <main>
        @yield('main')
    </main>

</body>

</html>
