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

  $getPage = function($slug, $default = null) {
    $page = \App\Models\Page::where('slug', $slug)->first();
    return $page ?: $default;
  };

@endphp

@section('title', (isset($siteName) ? $siteName : 'ASML') . ' - ' . $pageTitle)


@section('content')

  <!-- Page Title Section -->
  <section class="page-title light-background" style="padding-top: 100px; padding-bottom: 60px;">
    <div class="container">
      <h1>{{ $pageTitle }}</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          @foreach($breadcrumbs as $breadcrumb)
            @if($breadcrumb['url'])
            <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
            @else
            <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
            @endif
          @endforeach
        </ol>
      </nav>
    </div>
  </section>

    <!-- About Section -->
    <section id="about" class=" section" style="font-size: 16px;
              line-height: 1.8;
              color: 
          color-mix(in srgb, var(--default-color), transparent 25%);">

      <!-- Section Title -->
     
        @php $aboutPage = $getPage('about'); @endphp
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="content">
              <p>{!! $aboutPage?->content ?? 'We are a team of passionate professionals.' !!}</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            @php $aboutImg = $getPage('about')?->image; @endphp
            <img src="{{ $aboutImg ? asset('storage/' . $aboutImg) : asset('assets/img/about/about-square-12.webp') }}" class="img-fluid rounded" alt="About Image">
          </div>
        </div>
      </div>

    </section><!-- /About Section -->

    <!-- About Paragraphs Section -->
    @if($aboutParagraphs->count() > 0)
    <section id="about-paragraphs" class="section">
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
  
@endsection
