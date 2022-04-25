@extends('layouts.main', ['web' => $web])
@section('title', 'Dashboard')
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon" style="background-color: #444444">
          <i class="fas fa-archway"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pos</h4>
          </div>
          <div class="card-body">
            {{ $pos }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-road"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pos Gatur</h4>
          </div>
          <div class="card-body">
            {{ $pos_gatur }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-traffic-light"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Kemacetan</h4>
          </div>
          <div class="card-body">
            {{ $kemacetan }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-car-crash"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Kecelakaan</h4>
          </div>
          <div class="card-body">
            {{ $kecelakaan }}
          </div>
        </div>
      </div>
    </div>
   
  </div>
</section>
@endsection