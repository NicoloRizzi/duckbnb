@extends('layouts.app')

@section('content')
    <div class="container-fluid search">
        <div class="search--searching">
            <div class="search-bar">
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
                {{-- Origin point reference --}}
                @foreach($origin as $key => $value)
                    <input type="hidden" id="origin-{{ $key }}" name="origin-{{ $key }}" value="{{ $value }}">
                @endforeach
            </div>        
        </div>
        <div class="search--main container-fluid">
            
            <div class="search--main-sponsor">
                <div class="container">
                    <div class="search--main-sponsor--title">
                        <h2 class="weight-light text-main">Le migliori mete</h2>
                    </div>
                    <div class="search--main-sponsor--sponsored">
                        @foreach($sponsoreds as $item)
                        <div class="card card-apt">
                            <a href="{{ route('show', $item->id) }}" class="card-apt--img">
                                @if($item->img_url == 'https://picsum.photos/200/300')
                                    <img class="img-fluid" src="{{ $item->img_url }}" alt="">
                                @else
                                    <img class="img-fluid" src="{{ asset('storage/' . $item->img_url) }}" alt="">
                                @endif
                            </a>
                            <div class="card-apt--location">
                                <h5 class="weight-regular">
                                    Recensioni 
                                    (<span class="text-main">{{ count($item->reviews)}}</span>)
                                </h5>
                                <h5 id="address" class="weight-regular text-main" data-lat="{{ $item->lat }}" data-lng="{{ $item->lng }}"> Città </h5>
                            </div>
                            <div class="card-apt--title">
                                <h4 class="weight-regular"> {{ $item->title }} </h4>
                            </div>
                            <div class="card-apt--price">
                                <h4 class="weight-regular"> <span class="text-main weight-bold">{{ $item->price }}€</span> a notte</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
            </div>

            <div class="search--main-filter">
                <div class="search--main-filter--title">
                    <h3 class="weight-light text-light">Filtra la tua ricerca</h3>
                    <button class="button-shadow" id="reset">Resetta filtri</button>
                </div>

                <div class="search--main-filter--ctn">
                    
                    <div class="search--main-filter--ctn--rooms">
                        <label for="select-rooms">Stanze (minimo)</label>
                        <select class="search-option" name="Rooms" id="select-rooms">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    
                    <div class="search--main-filter--ctn--radius">
                        <p>Raggio di ricerca</p>
                        <div class="">
                            <form class="row search-option form-radius" id="select-radius">

                                <div class="form-radius--single">
                                    <label for="20">20 Km</label>
                                    <input type="radio" name="radius" id="20" value="20000" checked>
                                </div>

                                <div class="form-radius--single">
                                    <label for="30">30 Km</label>
                                    <input type="radio" name="radius" id="30" value="30000">
                                </div>
                                <div class="form-radius--single">
                                    <label for="50">50 Km</label>
                                    <input type="radio" name="radius" id="50" value="50000">
                                </div>
                                
        
                            </form>
                        </div>
                    </div>

                    <div class="search--main-filter--ctn--beds">
                        <label for="select-beds">Letti (minimo)</label>
                        <select class="search-option" name="Rooms" id="select-beds">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                
                <div class="search--main-filter--services">
                    <form class="search-option form-service" id="check-servizi">
                        @foreach($services as $service)
                            <div class="form-service--single">
                                <label for="{{ $service->name }}">{{ $service->name }}</label>        
                                <input type="checkbox" name="{{ $service->name }}" id="{{ $service->name }}" value="{{ $service->name }}" data-id="{{ $service->id }}">
                            </div>
                        @endforeach
                    </form>
                </div>

            </div>
            

            @if (!empty($apartments) && count($apartments) > 0)

                <div class="search--main-result container">
                    <h2 class="weight-light text-main">Risultati ricerca</h2>
                    <div class="row" id="search-results">
                        @foreach ($apartments as $apartment)
                            <div class="card card-apt">
                                <a href="{{ route('show', $apartment->id) }}" class="card-apt--img">
                                    @if($apartment->img_url == 'https://picsum.photos/200/300')
                                        <img class="img-fluid" src="{{ $apartment->img_url }}" alt="">
                                    @else
                                        <img class="img-fluid" src="{{ asset('storage/' . $apartment->img_url) }}" alt="">
                                    @endif
                                </a>
                                <div class="card-apt--location">
                                    <h5 class="weight-regular">
                                        Recensioni 
                                        (<span class="text-main">{{ count($apartment->reviews)}}</span>)
                                    </h5>
                                    <h5 id="address" class="weight-regular text-main" data-lat="{{ $apartment->lat }}" data-lng="{{ $apartment->lng }}"> Città </h5>
                                </div>
                                <div class="card-apt--title">
                                    <h4 class="weight-regular"> {{ $apartment->title }} </h4>
                                </div>
                                <div class="card-apt--price">
                                    <h4 class="weight-regular"> <span class="text-main weight-bold">{{ $apartment->price }}€</span> a notte</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="search--main-result no-result container">
                    <h3>Nessun risultato trovato</h3>
                </div>
            @endif
            
            @include('shared.handlebar')
            
        </div>
        
    </div>
@endsection



@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4/dist/algoliasearch-lite.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4"></script>
    <script src="https://cdn.jsdelivr.net/algoliasearch/3.31/algoliasearchLite.min.js"></script>
    <script src="{{ asset("js/search.js") }}" defer></script>
    <script src="{{ asset("js/search-filtering.js") }}" defer></script>
    <script src="{{ asset("js/reverse-geo.js") }}" defer></script>
@endpush