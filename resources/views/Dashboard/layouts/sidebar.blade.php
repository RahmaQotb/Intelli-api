<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        <li
            class="sidebar-item  ">
            <a href="{{route("dashboard.index")}}" class='sidebar-link'>
                <i class="">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                </i>
                <span>Dashboard</span>
            </a>


        </li>
        <li
            class="sidebar-item  ">
            <a href="{{route("dashboard.admin.create")}}" class='sidebar-link'>
                <i class="">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </i>
                <span>Add Admin</span>
            </a>


        </li>
        <li
            class="sidebar-item  ">
            <a href="{{route("dashboard.admin.change_password_form")}}" class='sidebar-link'>
                <i class="">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                </i>
                <span>Change Password</span>
            </a>


        </li>


        <li
        class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
            </i>
            <span>Categories</span>
        </a>

        <ul class="submenu ">

            <li class="submenu-item  ">
                <a href="{{route("dashboard.categories.index")}}" class="submenu-link">Show All Categories</a>

            </li>

            <li class="submenu-item  ">
                <a href="{{route("dashboard.categories.create")}}" class="submenu-link">Add Category</a>

            </li>

        </ul>


    </li>

    <li
    class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6zm10 0h6v6h-6zm-10 10h6v6h-6zm10 3h6m-3 -3v6" /></svg>
        </i>
        <span>Sub Categories</span>
    </a>

    <ul class="submenu ">

        <li class="submenu-item  ">
            <a href="{{route("dashboard.sub_categories.index")}}" class="submenu-link">Show All Sub Categories</a>

        </li>

        <li class="submenu-item  ">
            <a href="{{route("dashboard.sub_categories.create")}}" class="submenu-link">Add Sub Category</a>

        </li>

    </ul>


</li>
    <li
    class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-diamond"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5h12l3 5l-8.5 9.5a.7 .7 0 0 1 -1 0l-8.5 -9.5l3 -5" /><path d="M10 12l-2 -2.2l.6 -1" /></svg>
        </i>
        <span>Products</span>
    </a>

    <ul class="submenu ">

        <li class="submenu-item  ">
            <a href="{{route("dashboard.products.index")}}" class="submenu-link">Show All Products</a>

        </li>

        <li class="submenu-item  ">
            <a href="{{route("dashboard.products.create")}}" class="submenu-link">Add Products</a>

        </li>

    </ul>


</li>
      @auth
        <li class="sidebar-item  ">

            <form action="{{route('dashboard.auth.logout')}}" method="post">

                @csrf

                <div class="d-flex mt-2 justify-content-center">

                    <input type="hidden" name="dashboard-token" value="123456789">

                        <button type="submit" class="btn btn-danger">Logout</button>
                </div>
            </form>




        </li>
        @endauth

</div>
</div>
</div>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
