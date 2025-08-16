  <div class="app-menu">

            <!-- Sidenav Brand Logo -->
            <a href="index.html" class="logo-box">
                <!-- Light Brand Logo -->
                <div class="logo-light">
                    <img src="assets/images/logo-light.png" class="logo-lg h-6" alt="Light logo">
                    <img src="assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
                </div>

                <!-- Dark Brand Logo -->
                <div class="logo-dark">
                    <img src="assets/images/logo-dark.png" class="logo-lg h-6" alt="Dark logo">
                    <img src="assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
                </div>
            </a>

            <!-- Sidenav Menu Toggle Button -->
            <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
                <span class="sr-only">Menu Toggle Button</span>
                <i class="mgc_round_line text-xl"></i>
            </button>

            <!--- Menu -->
            <div class="srcollbar" data-simplebar>
                <ul class="menu" data-fc-type="accordion">
                    <li class="menu-title">Menu</li>

                    <li class="menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="menu-title">Apps</li>



                     {{-- <li class="menu-item">
                        <a href="{{ route('admin.nse') }}" class="menu-link">
                            <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                            <span class="menu-text">NSE List </span>
                        </a>
                    </li> --}}





                </ul>


            </div>
        </div>
