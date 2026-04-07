@extends('layouts.app')

@section('title', (isset($siteName) ? $siteName : 'ASML') . ' - ' . $portfolio->title)

@section('content')

<style>
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  .portfolio-banner-img {
    animation: fadeIn 1.2s ease-in-out;
  }

  .portfolio-banner-overlay {
    animation: fadeIn 1.2s ease-in-out;
  }

  .portfolio-banner-content {
    animation: fadeInUp 1s ease-in-out 0.3s both;
  }
</style>

<!-- Image Banner Section with Title Overlay -->
<section class="container" style="width: 100%; height: 400px; overflow: hidden; margin-top: 100px; position: relative; display: flex; align-items: center; justify-content: flex-start;">
  
  @if($portfolio->banner_image)
    <img src="{{ asset('storage/' . $portfolio->banner_image) }}" alt="{{ $portfolio->title }}" class="portfolio-banner-img" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
    
    <!-- Full dark overlay -->
    <div class="portfolio-banner-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2;"></div>
    
    <!-- Left Side Block - Auto Size -->
    <div class="portfolio-banner-content" style="position: relative; z-index: 3; background-color: rgb(92 93 94 / 90%); padding: 30px 40px; margin-left: 50px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); max-width: 600px; width: fit-content;">
      
      <h3 style="font-weight: 700; color: #fff; margin-bottom: 20px;">
        {{ $portfolio->title }}
      </h3>
      
      <p style="font-size: 15px; font-weight: 500; color: #fff; text-align: left; margin: 0; line-height: 1.6;">
        {{ $portfolio->short_description }}
      </p>
      
    </div>
    
  @else
    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0d6efd, #0dcaf0); display: flex; align-items: center; justify-content: center;">
      <i class="bi bi-briefcase" style="font-size: 5rem; color: white; opacity: 0.5;"></i>
    </div>
  @endif
  
</section>

<!-- Content Section -->
<section style="background: white; padding: 60px 0;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        @if($portfolio->description)
        <div style="color: #555; font-size: 1.05rem; line-height: 1.8; margin-bottom: 40px;">
          {!! $portfolio->description !!}
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

@endsection
