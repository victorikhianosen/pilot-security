<nav class="main-menu navbar-expand-md navbar-light">
    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
        <ul class="navigation clearfix">
            <li class="current dropdown">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="dropdown">
                <a href="#">About</a>
                <ul>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('team') }}">Our Team</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="{{ route('services') }}">Services</a>
            </li>
            <li class="dropdown">
                <a href="#">Research</a>
                <ul>
                    <li><a href="{{ route('nse') }}">NSE Trend</a></li>
                    <li><a href="{{ route('bonds') }}">Bonds</a></li>
                    <li><a href="{{ route('eft') }}">ETFs</a></li>
                </ul>
            </li>
            {{-- <li class="dropdown">
                    <a href="blog-grid.html">Blog</a>
                </li> --}}
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
    </div>
</nav>
