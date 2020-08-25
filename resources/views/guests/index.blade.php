@extends('layouts.app')

@section('content')

    <div class="jumbotron position-relative">
        <div class="search-bar position-absolute">
            <form class="search-bar--act" action="{{ route('search.submit') }}" method="POST">
                @csrf
                @method('POST')
                <div class="search-bar--act--input search-group">
                    <input id="address-input" placeholder="La tua prossima meta?"/>
                </div>
                <input type="hidden" id="lat" name="lat" value="">
                <input type="hidden" id="lng" name="lng" value="">
                <input type="hidden" id="apartmentId" name="id[]" value="">
                
                <button type="submit" class="search-bar--act--btnSubmit">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </form>
        </div>
    </div>

    <div class="divider-gradient"></div>

    <div class="container sponsor-section">
        <div class="row sponsor-section--title">
            <h2 class="weight-light">Le migliori mete</h2>
        </div>
        <div class="row sponsor-section--apts">
            @foreach($apartments as $apt)
                @if ($apt->is_visible==1)
                    <div class="card-apt">
                        <a href="{{ route('show', $apt->id) }}" class="card-apt--img">
                        @if($apt->img_url == 'https://picsum.photos/200/300')
                            <img class="img-fluid" src="{{ $apt->img_url }}" alt="">
                        @else
                            <img class="img-fluid" src="{{ asset('storage/' . $apt->img_url) }}" alt="">
                        @endif
                        </a>
                        <div class="card-apt--location">
                            <h5 class="weight-regular">
                                Recensioni 
                                (<span class="text-main">{{ count($apt->reviews)}}</span>)
                            </h5>
                            <h5 id="address" class="weight-regular text-main" data-lat="{{ $apt->lat }}" data-lng="{{ $apt->lng }}"> Città </h5>
                        </div>
                        <div class="card-apt--title">
                            <h4 class="weight-regular"> {{ $apt->title }} </h4>
                        </div>
                        <div class="card-apt--price">
                            <h4 class="weight-regular"> <span class="text-main weight-bold">{{ $apt->price }}€</span> a notte</h4>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4/dist/algoliasearch-lite.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4"></script>
    <script src="https://cdn.jsdelivr.net/algoliasearch/3.31/algoliasearchLite.min.js"></script>
    <script src="{{ asset("js/search.js") }}" defer></script>
    <script src="{{ asset("js/select.js") }}" defer></script>
    <script src="{{ asset("js/reverse-geo.js") }}" defer></script>
@endpush