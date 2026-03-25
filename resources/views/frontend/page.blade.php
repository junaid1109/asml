@extends('layouts.app')

@php
  $breadcrumbs = [
    ['label' => 'Home', 'url' => route('home')],
    ['label' => $page->title, 'url' => null]
  ];
@endphp

@section('title', $page->title . ' - ' . (isset($siteName) ? $siteName : 'ASML'))
@section('meta_description', $page->meta_description)

@section('content')

<!-- Page Title Section -->
<section class="page-title light-background" style="padding-top: 100px; padding-bottom: 60px;">
  <div class="container">
    <h1>{{ $page->title }}</h1>
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

<!-- Page Content -->
<section class="page-content section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        @if($page->image)
        <img src="{{ asset('storage/' . $page->image) }}" class="img-fluid rounded mb-4" alt="{{ $page->title }}">
        @endif

        <div class="content">
          {!! $page->content !!}
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
