<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
    />

    <title>Pilot Securities Limited</title>

    <!-- Fav Icon -->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700,700i&amp;display=swap"
      rel="stylesheet"
    />

    <!-- Stylesheets -->
    <link href="assets/css/font-awesome-all.css" rel="stylesheet" />
    <link href="assets/css/flaticon.css" rel="stylesheet" />
    <link href="assets/css/owl.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/jquery.fancybox.min.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet" />
    <link href="assets/css/nice-select.css" rel="stylesheet" />
    <link href="assets/css/color.css" rel="stylesheet" />
    <link href="assets/css/rtl.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
  </head>

  <!-- page wrapper -->
  <body class="boxed_wrapper ltr">
    <!-- Preloader -->
    <div class="loader-wrap">
      <div class="preloader style-two">
        <div class="preloader-close">Preloader Close</div>
      </div>
      <div class="layer layer-one"><span class="overlay"></span></div>
      <div class="layer layer-two"><span class="overlay"></span></div>
      <div class="layer layer-three"><span class="overlay"></span></div>
    </div>



    <!-- main header -->
    <header class="main-header style-two">
      <div class="header-upper">
        <div class="auto-container">
          <div class="upper-inner clearfix">
            <div class="logo-box pull-left">
              <figure class="logo">
                <a href="{{ route('home') }}"
                  ><img src="assets/images/logo-2.png" alt=""
                /></a>
              </figure>
            </div>
            <div class="info-box pull-right">
              <ul class="info-list clearfix">
                <li>
                  <i class="fas fa-phone-volume"></i>
                  <p>
                    Call Our Support<br /><a href="tel:01005200369"
                      >0816 227 4510</a
                    >
                  </p>
                </li>
                <li>
                  <i class="fas fa-map-marker-alt"></i>
                  <p>9 Younis Bashorun street, <br />VI, Lagos state</p>
                </li>
                <li>
                  <i class="far fa-clock"></i>
                  <p>Our Working Hours <br />Mon - Fr: 8 am - 6 pm</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="header-lower">
        <div class="outer-box">
          <div class="auto-container">
            <div class="menu-area clearfix">
              <!--Mobile Navigation Toggler-->
              <div class="mobile-nav-toggler">
                <i class="icon-bar"></i>
                <i class="icon-bar"></i>
                <i class="icon-bar"></i>
              </div>

            @include('layouts.navbar')

              <div class="menu-right-content clearfix">
                <div class="btn-box">
                  <a href="#" class="theme-btn style-two"
                    >Register</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--sticky Header-->
      <div class="sticky-header">
        <div class="auto-container">
          <div class="outer-box clearfix">
            <div class="logo-box pull-left">
              <figure class="logo">
                <a href="index.html"
                  ><img src="assets/images/logo-2.png" alt=""
                /></a>
              </figure>
            </div>
            <div class="menu-area pull-right">
              <nav class="main-menu clearfix">
                <!--Keep This Empty / Menu will come through Javascript-->
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- main-header end -->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
      <div class="menu-backdrop"></div>
      <div class="close-btn"><i class="fas fa-times"></i></div>

      <nav class="menu-box">
        <div class="nav-logo">
          <a href="index.html"
            ><img src="assets/images/mobile-logo.png" alt="" title=""
          /></a>
        </div>
        <div class="menu-outer">
          <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
        </div>
        <div class="contact-info">
          <h4>Contact Info</h4>
          <ul>
            <li>Chicago 12, Melborne City, USA</li>
            <li><a href="tel:+8801682648101">0816 227 4510</a></li>
            <li>
              <a href="mailto:info@example.com">info@pilotsecurities.com</a>
            </li>
          </ul>
        </div>
        <div class="social-links">
          <ul class="clearfix">
            <li>
              <a href="index.html"><span class="fab fa-twitter"></span></a>
            </li>
            <li>
              <a href="index.html"
                ><span class="fab fa-facebook-square"></span
              ></a>
            </li>
            <li>
              <a href="index.html"><span class="fab fa-pinterest-p"></span></a>
            </li>
            <li>
              <a href="index.html"><span class="fab fa-instagram"></span></a>
            </li>
            <li>
              <a href="index.html"><span class="fab fa-youtube"></span></a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
