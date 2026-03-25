@extends('layouts.app')

@section('title', (isset($siteName) ? $siteName : 'AMS') . ' - Advisory')

@section('content')

<!-- Advisory Hero Section -->
<section id="advisory-hero" class="hero section light-background" style="padding: 60px 0;">
  <div class="container" data-aos="fade-up">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="hero-content text-center">
          <h1 data-aos="fade-up">Advisory Services</h1>
          <p data-aos="fade-up" data-aos-delay="100">Get expert guidance and strategic advice for your business growth.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Advisory Content Section -->
<section id="advisory-content" class="advisory-content section">
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-12">
        <p class="text-center text-muted" style="padding: 60px 0;">
          <em>Advisory services and resources are coming soon. Contact us for more information.</em>
        </p>
      </div>
    </div>
  </div>
</section>

@endsection
