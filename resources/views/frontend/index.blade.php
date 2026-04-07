@extends('layouts.app')

@section('title', (isset($siteName) ? $siteName : 'AMS') . ' - Home')

@section('content')

@php
  // Helper function to get home section content
  $getSection = function($name, $default = null) use ($homeSections) {
    if ($homeSections) {
      $section = $homeSections->firstWhere('section_name', $name);
      return $section ?: $default;
    }
    return $default;
  };
@endphp

<!-- Hero Section -->
@php $heroSection = $getSection('hero'); @endphp
@if($heroSection?->is_active ?? true)
<section id="hero" class="hero section light-background">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content">
         
          <h1 data-aos="fade-up" data-aos-delay="200">{{ $getSection('hero')?->title ?? 'Transform Your Business Vision Into Reality' }}</h1>
           @if($getSection('hero')?->subtitle)
          <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="150">{{ $getSection('hero')->subtitle }}</p>
          @endif
          <p data-aos="fade-up" data-aos-delay="300">{!! $getSection('hero')?->description ?? 'We create innovative solutions.' !!}</p>
           <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
            @php 
              $heroSection = $getSection('hero');
              $videoFile = \App\Helpers\SettingHelper::get('demo_video_file');
              $videoUrl = \App\Helpers\SettingHelper::get('demo_video_url', 'https://www.youtube.com/watch?v=Y7f98aduVJ8');
            @endphp
            @if(\App\Helpers\SettingHelper::get('hero_cta_button_enabled', true))
            <a href="{{ $heroSection?->button_link ?? route('contact.index') }}" class="btn-primary">{{ $heroSection?->button_text ?? 'Get Started Today' }}</a>
            @endif
            @if(\App\Helpers\SettingHelper::get('demo_video_button_enabled', true))
              @if($videoFile)
                <!-- Play uploaded video file -->
                <a href="#videoModal" class="btn-secondary" data-bs-toggle="modal" onclick="playVideo('{{ asset('storage/' . $videoFile) }}', 'video/mp4')">
                  <i class="bi bi-play-circle"></i>
                  Watch Demo
                </a>
              @else
                <!-- Play YouTube/Vimeo video -->
                <a href="{{ $videoUrl }}" class="btn-secondary glightbox">
                  <i class="bi bi-play-circle"></i>
                  Watch Demo
                </a>
              @endif
            @endif
          </div>

          <!-- Video Modal for uploaded files -->
          @if($videoFile)
          <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Demo Video</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <video id="demoVideo" width="100%" controls style="border-radius: 8px;">
                    <source src="{{ asset('storage/' . $videoFile) }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                </div>
              </div>
            </div>
          </div>

          <script>
            function playVideo(src, type) {
              const video = document.getElementById('demoVideo');
              video.src = src;
              video.type = type;
              video.load();
              const modal = new bootstrap.Modal(document.getElementById('videoModal'));
              modal.show();
            }
          </script>
          @endif
        </div>
      </div>
      <div class="col-lg-6">
        @php $heroImg = $getSection('hero')?->image; @endphp
        <img src="{{ $heroImg ? asset('storage/' . $heroImg) : asset('assets/img/about/about-square-10.webp') }}" class="img-fluid" alt="Hero Image" data-aos="zoom-out" data-aos-delay="300">
      </div>
    </div>
  </div>
</section>
@endif

<!-- About Preview Section -->
@php $aboutSection = $getSection('about'); @endphp
@if($aboutSection?->is_active ?? true)
<section id="about" class="about section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="content">
          @php $aboutSection = $getSection('about'); @endphp
          <h2>{{ $aboutSection?->title ?? 'Crafting Excellence Through Innovation and Dedication' }}</h2>
          <p class="lead">{{ $aboutSection?->subtitle ?? 'We are passionate professionals.' }}</p>
          <p>{!! $aboutSection?->description ?? 'We are a team of passionate professionals.' !!}</p>

           <div class="cta-section" id="aboutCtaSection">
            <button class="btn btn-primary" style="border-color:black"><a href="{{ $aboutSection?->button_link ?? route('about') }}" class="btn-learn-more" style="color: #fff; text-decoration: none;">{{ $aboutSection?->button_text ?? 'Learn More' }}</a></button>
          </div>

          <style>
            @media (max-width: 768px) {
              #aboutCtaSection {
                text-align: center;
                padding-bottom: 10px;
              }
            }
          </style>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        @php $aboutImg = $getSection('about')?->image; @endphp
        <img src="{{ $aboutImg ? asset('storage/' . $aboutImg) : asset('assets/img/about/about-square-12.webp') }}" class="img-fluid rounded" alt="About Image">
      </div>
    </div>
  </div>
</section>
@endif

<!-- Why Choose Us Section -->
@php $whyUsSection = $getSection('why-us'); @endphp
@if($whyUsSection?->is_active==1)
<section id="why-us" class="why-us section">
  <div class="container section-title" data-aos="fade-up">
    <h2>{{ $whyUsSection?->title ?? 'Why Choose Us' }}</h2>
    @if($whyUsSection?->tagline)
    <p>{{ $whyUsSection->tagline }}</p>
    @endif
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="content">
          <h2>{{ $whyUsSection?->subtitle ?? 'Why Partner With Us' }}</h2>
          <p>{!! $whyUsSection?->description ?? 'We deliver exceptional results through proven expertise,' !!}</p>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        @php $whyUsImg = $getSection('why-us')?->image; @endphp
        <img src="{{ $whyUsImg ? asset('storage/' . $whyUsImg) : asset('assets/img/about/about-8.webp') }}" alt="Professional team collaboration" class="img-fluid">
      </div>
    </div>

    <div class="" data-aos="fade-up" data-aos-delay="400">
      <div class="row">
        @forelse($features as $feature)
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-item">
            <div class="icon-wrapper">
              @if($feature->icon_file)
              <img src="{{ asset('storage/' . $feature->icon_file) }}" alt="{{ $feature->title }} icon" class="feature-icon" style="max-width: 48px; max-height: 48px;">
              @else
              <i class="bi bi-lightbulb"></i>
              @endif
            </div>
            <div class="feature-content">
              <h3>{{ $feature->title }}</h3>
              <p>{{ $feature->description }}</p>
            </div>
          </div>
        </div>
        @empty
        <div class="col-lg-12 text-center">
          <p>No features available.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</section>
@endif



<section id="services" class="services section light-background">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="section-title">
       @php $portfolioSection = $getSection('portfolio'); @endphp
      <h2>{{ $portfolioSection?->title ?? 'Portfolio' }}</h2>
      <p>{!! $portfolioSection?->description ?? 'Strategically' !!}</p>
    </div>

    <div class="row gy-5">
      @foreach($portfolios as $service)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item">
          @if($service->image)
          <div class="service-image" style="width: 100%; height: 200px; overflow: hidden; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="width: 100%; height: 100%;">
          </div>
          @endif
          <h2>{{ $service->title }}</h2>
          <p>{{ $service->short_description }}</p>
          <a href="{{ route('portfolio.show', $service->id) }}" class="learn-more-btn">
            Learn More <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>



<!-- Call To Action Section -->
@if($getSection('call-to-action')?->is_active)
@php $ctaSection = $getSection('call-to-action'); @endphp
<section id="call-to-action" class="call-to-action section" style="
      background: linear-gradient(rgba(13, 110, 253, 0.4), rgba(13, 110, 253, 0.4)), 
      url('{{ $ctaSection?->image ? asset('storage/' . $ctaSection->image) : asset('assets/img/about/about-8.webp') }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      padding: 80px 0;
      color: white;
  ">
  <div class="container" data-aos="fade-up">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-8 text-center">
        <h2 style="color: white; font-weight: 700; margin-bottom: 15px;">{{ $ctaSection?->title ?? 'Ready to Transform Your Business?' }}</h2>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.1rem; margin-bottom: 30px;">{!! $ctaSection?->description ?? 'Connect with us today and discover how we can help you achieve your goals.' !!}</p>
      </div>
    </div>
  </div>
</section>
@endif

@endsection
