@extends('layouts.backend')
@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
        <h1 class="m-0">Dashboard</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid page__container">
  </div>
@endsection
