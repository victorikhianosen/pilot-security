<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pilot Securities</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pilot Securities Login Page" name="description">
    <meta content="Pilot Securities" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('auth/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{ asset('auth/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme Config Js -->
    <script src="{{ asset('auth/assets/js/config.js') }}"></script>
</head>

<body>

    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflow-hidden sm:rounded-md rounded-none">
                    <div class="p-6">
                        <a href="{{ url('/') }}" class="block mb-8">
                            <img class="h-6 block dark:hidden" src="{{ asset('assets/images/logo-2.png') }}"
                                alt="Pilot Securities Logo">
                       
                        </a>

                        <form action="{{ route('login.store') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2"
                                    for="LoggingEmailAddress">Email Address</label>
                                <input name="email" autocomplete="" id="LoggingEmailAddress" class="form-input w-full" type="email" value="{{ old('email') }}"
                                    placeholder="Enter your email">
                                @error('email')
                                    <span style="color: red; font-size: 14px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2"
                                    for="loggingPassword">Password</label>
                                <input autocomplete="" name="password" id="loggingPassword" class="form-input w-full" type="password"
                                    placeholder="Enter your password">
                                @error('password')
                                    <span style="color: red; font-size: 14px;">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="flex justify-center mb-6">
                                <button class="btn w-full text-white bg-primary">Log In</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('layouts.sweet-alert')

</body>

</html>
