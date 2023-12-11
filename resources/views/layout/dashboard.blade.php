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
            @php
                $logo = App\Models\Logo::first();
                $logoId = $logo->id;
                $logoPath = $logo ? $logo->path : null;
            @endphp
            {{-- nav logo --}}
            <div class="logo-image">
                <img src="{{ asset($logoPath) }}" alt="Logo">
            </div>
            {{-- Name of website --}}
            <span class="logo-name">New</span>
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
                <li id="activity_log">
                    <a id="activity_log_link">
                        <i class='bx bxs-time'></i>
                        <span class="link-name">Activity Log</span>
                        <i class='bx bx-chevron-left arrow'></i>
                    </a>
                    <ul class="sub-menu" id="activity_log_sub_menu">
                        {{-- Users --}}
                        <li>
                            <a href="{{ route('admin.activity_log.index', 'user') }}">
                                <i class='bx bxs-user'></i>
                                <span class="link-name">User</span>
                            </a>
                        </li>
                        {{-- Permission --}}
                        <li>
                            <a href="{{ route('admin.activity_log.index', 'permission') }}">
                                <i class='bx bxs-lock-open'></i>
                                <span class="link-name">Permission</span>
                            </a>
                        </li>
                        {{-- Role --}}
                        <li>
                            <a href="{{ route('admin.activity_log.index', 'role') }}">
                                <i class='bx bxs-briefcase'></i>
                                <span class="link-name">Role</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li id="setting">
                    <a id="setting_link">
                        <i class='bx bxs-cog'></i>
                        <span class="link-name">Setting</span>
                        <i class='bx bx-chevron-left arrow'></i>
                    </a>
                    <ul class="sub-menu" id="setting_sub_menu">
                        <li>

                            <a href="{{ route('admin.logos.edit', $logoId) }}">
                                <i class='bx bxs-image'></i>
                                <span class="link-name">Update Logo</span>
                            </a>
                        </li>
                    </ul>
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
    <script>

        // Activity Log
        const activityLogLink = document.getElementById('activity_log_link');
        const activityLogSubMenu = document.getElementById('activity_log_sub_menu');
        const activityLogArrow = activityLogLink.querySelector('.arrow');

        activityLogLink.addEventListener('click', () => {
            activityLogSubMenu.classList.toggle('show');
            activityLogArrow.classList.toggle('rotate');
        });
    </script>
    <script>

        // Setting
        const settingLink = document.getElementById('setting_link');
        const settingSubMenu = document.getElementById('setting_sub_menu');
        const settingArrow = settingLink.querySelector('.arrow');

        settingLink.addEventListener('click', () => {
            settingSubMenu.classList.toggle('show');
            settingArrow.classList.toggle('rotate');
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
                <span class="user-name">Welcome <a href="{{ route('admin.users.profile') }}"> <span
                            class="user-name-name">{{ auth()->user()->name }}</span></a></span>
            </div>

        </div>
    </section>
    @include('layout.toastr')
    <main>
        @yield('main')
    </main>

</body>

</html>
