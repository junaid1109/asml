<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', (isset($siteName) ? $siteName : config('app.name', 'AMS')) . ' - Professional Business')</title>
  <meta name="description" content="@yield('meta_description', 'Professional Business')">
  <meta name="keywords" content="@yield('meta_keywords', '')">

  <!-- Favicons -->
  @php
    $favicon = \App\Helpers\SettingHelper::get('site_favicon');
  @endphp
  @if($favicon)
  <link href="{{ asset('storage/' . $favicon) }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('storage/' . $favicon) }}" rel="icon" type="image/png" sizes="any">
  @else
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/png" sizes="any">
  @endif
  
  <!-- Apple Touch Icon - Multiple sizes for iPad and iPhone -->
  @if($favicon)
  <link href="{{ asset('storage/' . $favicon) }}" rel="apple-touch-icon" sizes="180x180">
  <link href="{{ asset('storage/' . $favicon) }}" rel="apple-touch-icon" sizes="152x152">
  <link href="{{ asset('storage/' . $favicon) }}" rel="apple-touch-icon" sizes="144x144">
  <link href="{{ asset('storage/' . $favicon) }}" rel="apple-touch-icon" sizes="120x120">
  @else
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="152x152">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="144x144">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="120x120">
  @endif
  
  <!-- Web App Manifest for PWA and Android -->
  <link href="{{ asset('manifest.json') }}" rel="manifest">
  
  <!-- Theme Color for Mobile -->
  <meta name="theme-color" content="#0d6efd">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}?v={{ time() }}" rel="stylesheet">

  <!-- Standardized Image Sizing -->
  <style>
    /* Services Section - Listing Images */
    .service-image {
      height: 300px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }

    .service-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    /* Services Detail Page Image */
    .service-details .col-lg-10 > img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      object-position: center;
    }

    /* Team Member Images */
    .member-img {
      height: 280px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }

    .member-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    /* Hero Section Image */
    .hero img {
      width: 100%;
      height: auto;
      max-height: 500px;
      object-fit: cover;
      object-position: center;
    }

    /* Footer Contact Strong Tags Gap */
    .footer-contact strong {
      margin-right: 8px;
      display: inline-block;
    }
    .footer-contact p {
      line-height: 2.2;
    }

    /* CKEditor Content Styling - Image Alignments */
    .text-block-content,
    .member-details,
    [class*="content"] figure,
    figure.image {
      /* Base styling */
    }

    /* Default figure styling for all CKEditor content */
    figure.image {
      display: block;
      margin: 10px 0;
    }

    figure.image img {
      max-width: 100%;
      height: auto;
      display: block;
    }

    figure.image figcaption {
      font-size: 0.85rem;
      color: #888;
      margin-top: 8px;
      text-align: center;
      font-style: italic;
    }

    /* Full width images */
    figure.image.image-style-full,
    .ck-content .image-style-full {
      width: 100%;
      margin: 15px 0;
      display: block !important;
    }

    figure.image.image-style-full img,
    .ck-content .image-style-full img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Center align images - HIGHEST PRIORITY */
    figure.image.image-style-center,
    figure.image.image-style-align-center,
    figure.image[style*="align-center"],
    figure.image[style*="text-align:center"],
    .text-block-content figure.image-style-center,
    .member-details figure.image-style-center {
      display: block !important;
      text-align: center !important;
      margin: 15px auto !important;
      clear: both !important;
      max-width: 100%;
      width: auto !important;
    }

    figure.image.image-style-center img,
    figure.image.image-style-align-center img,
    figure.image[style*="align-center"] img,
    figure.image[style*="text-align:center"] img {
      width: auto !important;
      max-width: 100%;
      height: auto;
      display: inline-block !important;
      margin: 0 auto !important;
    }

    /* Universal center align for all figure elements */
    figure[style*="text-align: center"] {
      text-align: center !important;
      margin: 15px auto !important;
      display: block !important;
      width: auto !important;
    }

    figure[style*="text-align: center"] img {
      display: inline-block !important;
      margin: 0 auto !important;
    }

    /* Side/Float right images */
    figure.image.image-style-side,
    figure.image.image-style-align-right,
    figure.image.image_resized.w50 figure,
    .text-block-content figure.image-style-side {
      float: right;
      margin: 0 0 20px 25px;
      max-width: 45%;
      clear: right;
      display: block;
    }

    figure.image.image-style-side img,
    figure.image.image-style-align-right img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Left align images */
    figure.image.image-style-left,
    figure.image.image-style-align-left,
    figure.image[style*="align-left"],
    .text-block-content figure.image-style-left {
      float: left;
      margin: 0 25px 20px 0;
      max-width: 45%;
      clear: left;
      display: block;
    }

    figure.image.image-style-left img,
    figure.image.image-style-align-left img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Right align images */
    figure.image.image-style-right,
    figure.image.image-style-align-right,
    figure.image[style*="align-right"],
    .text-block-content figure.image-style-right {
      float: right;
      margin: 0 0 20px 25px;
      max-width: 45%;
      clear: right;
      display: block;
    }

    figure.image.image-style-right img,
    figure.image.image-style-align-right img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Handle inline styles from CKEditor */
    figure[style*="text-align"] {
      text-align: inherit !important;
    }

    figure[style*="text-align: left"] {
      text-align: left;
      margin: 10px 0;
      display: block;
    }

    figure[style*="text-align: right"] {
      text-align: right;
      margin: 10px 0;
      display: block;
    }

    /* Member bio content wrapper styling */
    .member-bio-content {
      display: block;
    }

    .member-bio-content figure.image-style-center,
    .member-bio-content figure[style*="text-align: center"],
    .member-bio-content figure[style*="align-center"] {
      text-align: center !important;
      margin: 15px auto !important;
      display: block !important;
      clear: both !important;
    }

    .member-bio-content figure.image-style-center img,
    .member-bio-content figure[style*="text-align: center"] img,
    .member-bio-content figure[style*="align-center"] img {
      display: inline-block !important;
      margin: 0 auto !important;
      text-align: center;
    }

    /* Clear floats after content */
    .text-block-content::after,
    .member-details::after,
    .member-bio-content::after {
      content: "";
      display: table;
      clear: both;
    }

    /* CKEditor Table Styling */
    table,
    .text-block-content table,
    .member-details table,
    .member-bio-content table,
    [class*="content"] table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      border: 1px solid #ddd;
    }

    table thead,
    .text-block-content table thead,
    .member-details table thead,
    .member-bio-content table thead {
      background-color: #f8f9fa;
    }

    table th,
    .text-block-content table th,
    .member-details table th,
    .member-bio-content table th {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
      font-weight: 600;
      color: #333;
      background-color: #f8f9fa;
    }

    table td,
    .text-block-content table td,
    .member-details table td,
    .member-bio-content table td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      color: #555;
    }

    table tbody tr:hover,
    .text-block-content table tbody tr:hover,
    .member-details table tbody tr:hover,
    .member-bio-content table tbody tr:hover {
      background-color: #f5f5f5;
    }

    table tbody tr:nth-child(odd),
    .text-block-content table tbody tr:nth-child(odd),
    .member-details table tbody tr:nth-child(odd),
    .member-bio-content table tbody tr:nth-child(odd) {
      background-color: #fafafa;
    }

    /* Responsive table */
    @media (max-width: 768px) {
      table,
      .text-block-content table,
      .member-details table,
      .member-bio-content table {
        font-size: 14px;
      }

      table th,
      table td,
      .text-block-content table th,
      .text-block-content table td,
      .member-details table th,
      .member-details table td,
      .member-bio-content table th,
      .member-bio-content table td {
        padding: 8px 10px;
      }
    }

    /* Responsive adjustments for smaller screens */
    @media (max-width: 768px) {
      figure.image.image-style-side,
      figure.image.image-style-left,
      figure.image.image-style-right,
      .member-bio-content figure.image-style-side,
      .member-bio-content figure.image-style-left,
      .member-bio-content figure.image-style-right {
        float: none !important;
        margin: 15px 0 !important;
        max-width: 100%;
        clear: both;
      }

      figure.image.image-style-side img,
      figure.image.image-style-left img,
      figure.image.image-style-right img,
      .member-bio-content figure img {
        width: 100%;
      }

      .member-img {
        height: auto !important;
        max-height: none !important;
      }

      .member-img img {
        height: auto !important;
        width: 100%;
      }
    }

    .footer-map h4 {
      margin-bottom: 15px;
      font-size: 16px;
    }

    .footer-map .map-container {
      width: 100%;
      height: 180px;
    }

    .footer-map iframe {
      width: 100%;
      height: 180px;
      border-radius: 8px;
    }

    /* Mobile Footer Centering */
    @media (max-width: 768px) {
      .footer-info,
      .footer-links,
      .footer-contact,
      .footer-map {
        text-align: center !important;
      }

      .footer-info .logo {
        justify-content: center;
      }

      .footer-info .social-links {
        justify-content: center;
      }

      .footer-links h4,
      .footer-contact h4,
      .footer-map h4 {
        text-align: center !important;
      }

      .footer-links ul {
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: 0 !important;
        list-style: none !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
      }

      .footer-links ul li {
        text-align: center !important;
        width: auto !important;
      }

      .footer-links ul li a {
        display: inline-block !important;
        padding: 5px 0 !important;
      }

      .footer-contact p {
        text-align: center !important;
      }

      .footer-contact strong {
        display: block;
        margin-bottom: 5px;
      }

      .footer-map {
        margin-top: 20px;
      }
    }

    /* Portfolio Item Buttons */
    .portfolio-item-buttons {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
    }

    .portfolio-item-btn {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      font-size: 0.95rem;
      border: none;
      cursor: pointer;
      white-space: nowrap;
    }

    .portfolio-item-btn:not([target="_blank"]) {
      background-color: var(--accent-color);
      color: white !important;
    }

    .portfolio-item-btn:not([target="_blank"]):hover {
      background-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .portfolio-item-btn[target="_blank"] {
      background-color: transparent;
      color: var(--accent-color);
      border: 1px solid var(--accent-color);
    }

    .portfolio-item-btn[target="_blank"]:hover {
      background-color: var(--accent-color);
      color: white;
      transform: translateY(-2px);
    }

    .portfolio-item-btn i {
      margin-left: 8px;
    }

    /* Homepage Portfolio Learn More Button */
    .learn-more-btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: #0d6efd;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .learn-more-btn:hover {
      background-color: var(--accent-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .learn-more-btn i {
      margin-left: 8px;
    }
  </style>

  @stack('css')
</head>

<body>

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        @php
          $logo = \App\Helpers\SettingHelper::get('site_logo');
        @endphp
        @if($logo)
        <img src="{{ asset('storage/' . $logo) }}" alt="{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}" style="max-height: 50px;">
        @else
        <h1 class="sitename">{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}</h1>
        @endif
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="@if(Route::currentRouteName() == 'home') active @endif">Home</a></li>
            @forelse(\App\Models\Page::where('published', 1)->whereIn('display_location', ['header', 'both'])->orderBy('order')->get() as $page)
              <li><a href="{{ route('page.show', $page) }}" class="@if(Route::currentRouteName() == $page->slug) active @endif">{{ $page->title }}</a></li>
            @empty
            @endforelse
          <li><a href="{{ route('contact.index') }}" class="@if(Route::currentRouteName() == 'contact.index') active @endif">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer light-background">
      <div class="container">
        <div class="row gy-4">

          <div class="col-lg-3 col-md-12 footer-info">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
              @php
                $logo = \App\Helpers\SettingHelper::get('site_logo');
              @endphp
              @if($logo)
              <img src="{{ asset('storage/' . $logo) }}" alt="{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}" style="margin-top: 25px;max-height: 120px;">
              @else
              <h1 class="sitename">{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}</h1>
              @endif
            </a>
            <p>{{ \App\Helpers\SettingHelper::get('footer_description', 'Your company description goes here. This is a professional business template.') }}</p>
            <div class="social-links d-flex mt-4">
              @php
                $twitter = \App\Helpers\SettingHelper::get('twitter_url');
                $facebook = \App\Helpers\SettingHelper::get('facebook_url');
                $instagram = \App\Helpers\SettingHelper::get('instagram_url');
                $linkedin = \App\Helpers\SettingHelper::get('linkedin_url');
              @endphp
              @if($twitter)
              <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
              @endif
              @if($facebook)
              <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
              @endif
              @if($instagram)
              <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
              @endif
              @if($linkedin)
              <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
              @endif
            </div>
          </div>
          <!-- <div class="col-lg-1"></div> -->
          <div class="col-lg-2 col-md-12 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="{{ route('home') }}">Home</a></li>
              <li><a href="{{ route('about') }}">About</a></li>
              <li><a href="{{ route('contact.index') }}">Contact</a></li>
             
            </ul>
          </div>

          <div class="col-lg-2 col-md-12 footer-links">
            <h4>Pages</h4>
            <ul>
              @forelse(\App\Models\Page::where('published', 1)->whereIn('display_location', ['footer', 'both'])->orderBy('order')->get() as $page)
                <li><a href="{{ route('page.show', $page) }}">{{ $page->title }}</a></li>
              @empty
              @endforelse
            </ul>
          </div>

          <div class="col-lg-2 col-md-12 footer-contact text-lg-left">
            <h4>Contact Us</h4>
            <p>
              <strong>Address:</strong> {{ \App\Helpers\SettingHelper::get('site_address', 'A108 Adam Street, New York, NY 535022') }}<br>
              <strong>Phone:</strong> {{ \App\Helpers\SettingHelper::get('site_phone', '+1 5589 55488 55') }}<br>
              <strong>Fax:</strong> {{ \App\Helpers\SettingHelper::get('site_fax', '+1 5589 55488 55') }}<br>
              <strong>Email:</strong> {{ \App\Helpers\SettingHelper::get('site_email', 'info@ams.com') }}<br>
            </p>
          </div>

          {{-- Google Map Section --}}
          <div class="col-lg-3 col-md-12 footer-map">
            <h4>Our Location</h4>
            <div class="map-container" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
              @php
                $mapEmbed = \App\Helpers\SettingHelper::get('google_map_embed');
                $mapLat = \App\Helpers\SettingHelper::get('map_latitude', '40.7128');
                $mapLng = \App\Helpers\SettingHelper::get('map_longitude', '-74.0060');
              @endphp
              
              @if($mapEmbed)
                {!! $mapEmbed !!}
              @else
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3588.4755285851644!2d28.129372!3d-25.9762582!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e956e39a536eab9%3A0xe1ab4b1ab867acd4!2s500%2016th%20Rd%2C%20Randjespark%2C%20Midrand%2C%201683%2C%20South%20Africa!5e0!3m2!1sen!2sus!4v1234567890"
                  width="100%" 
                  height="180" 
                  style="border:0;" 
                  allowfullscreen="" 
                  loading="lazy" 
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
              @endif
            </div>
          </div>

        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }}</span> <strong class="px-1">{{ isset($siteName) ? $siteName : config('app.name', 'AMS') }}</strong> <span>All Rights Reserved</span></p>
      </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @stack('js')

</body>

</html>
