@extends('layouts.app')

@php
  $currentMenu = \App\Models\Menu::getCurrentPageMenu();
  $pageTitle = $currentMenu?->label ?? 'About';
  $breadcrumbs = \App\Models\Menu::getBreadcrumbs();

   $getSection = function($name, $default = null) use ($homeSections) {
    if ($homeSections) {
      $section = $homeSections->firstWhere('section_name', $name);
      return $section ?: $default;
    }
    return $default;
  };

@endphp

@section('title', (isset($siteName) ? $siteName : 'ASML') . ' - ' . $pageTitle)


@section('content')

 <main class="main main-page">

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
      </div><!-- End Section Title -->
    @php $aboutSection = $getSection('about'); @endphp
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="content">
              @php $aboutSection = $getSection('about'); @endphp
              <h2>{{ $aboutSection?->title ?? 'Crafting Excellence Through Innovation and Dedication' }}</h2>
              <p class="lead">{{ $aboutSection?->subtitle ?? 'We are passionate professionals.' }}</p>
              <p>{!! $aboutSection?->description ?? 'We are a team of passionate professionals.' !!}</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            @php $aboutImg = $getSection('about')?->image; @endphp
            <img src="{{ $aboutImg ? asset('storage/' . $aboutImg) : asset('assets/img/about/about-square-12.webp') }}" class="img-fluid rounded" alt="About Image">
          </div>
        </div>
      </div>

    </section><!-- /About Section -->

    <!-- About Paragraphs Section -->
    @if($aboutParagraphs->count() > 0)
    <section id="about-paragraphs" class="about section">
      <div class="container">
        @foreach($aboutParagraphs as $paragraph)
        <div class="row gy-4 mb-5" data-aos="fade-up" data-aos-delay="100">
          <div class="col-12">
            <h3 class="mb-3">{{ $paragraph->title }}</h3>
            <div class="about-content">
              {!! $paragraph->details !!}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </section>
    @endif
    <!-- End About Paragraphs Section -->

    <!-- Portfolio Section -->
    @if($portfolios->count() > 0)
    <section id="portfolio" class="services section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Our Portfolio</h2>
          <p>Explore our latest projects and achievements</p>
        </div>

        <div class="row gy-5">
          @foreach($portfolios as $portfolio)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item">
              @if($portfolio->image)
              <div class="service-image" style="width: 100%; height: 200px; overflow: hidden; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              @endif
              <h3>{{ $portfolio->title }}</h3>
              <p>{{ Str::limit(strip_tags($portfolio->description), 100) }}</p>
              @if($portfolio->link)
              <a href="{{ $portfolio->link }}" class="readmore" target="_blank">
                <span>View Details</span>
                <i class="bi bi-arrow-right"></i>
              </a>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif
    <!-- End Portfolio Section -->

  </main>
@endsection
