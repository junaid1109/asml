@extends('layouts.app')

@section('title', (isset($siteName) ? $siteName : 'AMS') . ' - Portfolio')

@section('content')

@php
  $getSection = function($name, $default = null) use ($homeSections) {
    if ($homeSections) {
      $section = $homeSections->firstWhere('section_name', $name);
      return $section ?: $default;
    }
    return $default;
  };
@endphp

<!-- Portfolio Hero Section -->
<section id="portfolio-hero" class="hero section light-background" style="padding: 60px 0;">
  <div class="container" data-aos="fade-up">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="hero-content text-center">
          <h1 data-aos="fade-up">Our Portfolio</h1>
          <p data-aos="fade-up" data-aos-delay="100">Explore our latest projects and see how we transform ideas into successful outcomes.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Portfolio Items Section -->
<section id="portfolio-items" class="portfolio-items section">
  <div class="container" data-aos="fade-up">
    @if($portfolios->isEmpty())
    <div class="row">
      <div class="col-12">
        <p class="text-center text-muted" style="padding: 60px 0;">
          <em>Portfolio items are coming soon. Check back later for our latest work!</em>
        </p>
      </div>
    </div>
    @else
    <div class="row">
      @foreach($portfolios as $portfolio)
      <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
        <div class="portfolio-item card h-100 shadow-sm">
          @if($portfolio->image)
          <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" class="card-img-top portfolio-item-img">
          @else
          <div class="portfolio-item-img bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
            @if($portfolio->icon)
            <i class="bi {{ $portfolio->icon }}" style="font-size: 3rem; color: var(--accent-color);"></i>
            @else
            <i class="bi bi-briefcase" style="font-size: 3rem; color: var(--accent-color);"></i>
            @endif
          </div>
          @endif
          
          <div class="portfolio-item-content card-body">
            @if($portfolio->category)
            <p class="portfolio-item-category">{{ $portfolio->category }}</p>
            @endif
            <h5 class="portfolio-item-title">{{ $portfolio->title }}</h5>
            @if($portfolio->description)
            <p class="portfolio-item-desc">{{ Str::limit($portfolio->description, 100) }}</p>
            @endif
            
            @if($portfolio->link)
            <a href="{{ $portfolio->link }}" target="_blank" class="portfolio-item-btn">
              View Project <i class="bi bi-arrow-right"></i>
            </a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

@endsection
