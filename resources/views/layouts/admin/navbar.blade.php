 <header class="app-header flex items-center px-4 gap-3">
     <!-- Sidenav Menu Toggle Button -->
     <button id="button-toggle-menu" class="nav-link p-2">
         <span class="sr-only">Menu Toggle Button</span>
         <span class="flex items-center justify-center h-6 w-6">
             <i class="mgc_menu_line text-xl"></i>
         </span>
     </button>

     <!-- Topbar Brand Logo -->
     <a href="index.html" class="logo-box">
         <!-- Light Brand Logo -->
         <div class="logo-light">

         </div>

         <!-- Dark Brand Logo -->
         <div class="logo-dark">

         </div>
     </a>

     <!-- Topbar Search Modal Button -->
     <button type="button" data-fc-type="modal" data-fc-target="topbar-search-modal" class="nav-link p-2 me-auto">

     </button>

     <!-- Language Dropdown Button -->
     <div class="relative">

     </div>

     <!-- Notification Bell Button -->
     <div class="relative md:flex hidden">

     </div>


     <!-- Profile Dropdown Button -->
     <div class="relative">
         <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link">
             <img src="{{ asset('assets/images/favicon.png') }}" alt="user-image" class="rounded-full h-10">
         </button>
         <div
             class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 mt-2 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">

             {{-- <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="auth-login.html">
                            <i class="mgc_lock_line  me-2"></i>
                            <span>Lock Screen</span>
                        </a> --}}
             <hr class="my-2 -mx-2 border-gray-200 dark:border-gray-700">
             <a href="{{ route('admin.logout') }}"
                 class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                 <i class="mgc_exit_line  me-2"></i>
                 <span>Log Out</span>
             </a>
         </div>
     </div>
 </header>
