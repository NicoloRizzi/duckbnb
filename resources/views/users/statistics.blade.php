@extends('layouts.app')

@section('content')
    <div class="container-fluid stats">
        <div class="container">
            <div class="stats-title">
                <h2>Statistiche</h2>
                <h3 class="weight-light text-main">{{ $apartment->title }}</h3>
            </div>
        </div>    
        <div id="total-views" class="stats-tot container-fluid">
            <div class="stats-tot--ctn">
                <h4 class="weight-light">Visualizzazioni</h4>
                <h4><span></span></h4>
            </div>
            <div class="stats-tot--ctn">
                <h4 class="weight-light">Messaggi</h4>
                <h4>
                    {{ $apartment->messages->count() }}
                </h4>
            </div>
        </div>
        <div class="container">
            <div class="stats-graphs">
                <div class="stats-graphs--view chart-container">
                    <canvas id="viewsPerMonth" width="300px" height="300px" ></canvas>
                </div>
                <div class="stats-graphs--view chart-container">
                    <canvas id="pieChart" width="300px" height="300px"></canvas>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/views-chart.js') }}"></script>
@endpush
