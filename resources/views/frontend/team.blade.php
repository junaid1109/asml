@extends('layouts.app')

@php
  $currentMenu = \App\Models\Menu::getCurrentPageMenu();
  $pageTitle = $currentMenu?->label ?? 'Team';
  $breadcrumbs = \App\Models\Menu::getBreadcrumbs();
@endphp

@section('title', (isset($siteName) ? $siteName : 'ASML') . ' - ' . $pageTitle)

@section('content')

<!-- Team Section -->

 

  <section id="team" class="team section">
<!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Team</h2>
    <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
  </div><!-- End Section Title -->

    <div class="container">
      <div class="row gy-5">
        @foreach($teamMembers as $member)
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index % 2 == 0 ? 100 : 200 }}">
          <div class="team-member d-flex align-items-start">
            <div class="pic" style="flex-shrink: 0; margin-right: 20px;">
              @if($member->image)
                <img src="{{ asset('storage/' . $member->image) }}" class="img-fluid" alt="{{ $member->name }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
              @else
                <img src="{{ asset('assets/img/person/person-f-6.webp') }}" class="img-fluid" alt="{{ $member->name }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
              @endif
            </div>
            <div class="member-info">
              <h4>{{ $member->name }}</h4>
              <span>{{ $member->position }}</span>
              @if($member->bio)
              <p style="margin-top: 8px; color: #666; font-size: 0.95rem;">{{ Str::limit(strip_tags($member->bio), 150) }}</p>
              @endif
              <div class="social" style="margin-top: 12px;">
                @if($member->twitter)<a href="{{ $member->twitter }}" target="_blank"><i class="bi bi-twitter-x"></i></a>@endif
                @if($member->facebook)<a href="{{ $member->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif
                @if($member->instagram)<a href="{{ $member->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>@endif
                @if($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a>@endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </section>

@endsection
