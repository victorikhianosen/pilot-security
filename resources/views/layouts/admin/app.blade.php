@include('layouts.admin.header')

        @include('layouts.admin.sidebar')
        <!-- Sidenav Menu End  -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <!-- Topbar Start -->

            @include('layouts.admin.navbar')
            <!-- Topbar End -->

            @yield('admin_content')



@include('layouts.admin.footer')
