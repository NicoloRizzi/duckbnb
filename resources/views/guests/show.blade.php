@extends('layouts.app')

@section('content')

<div class="container show-page">
    
    <h2 class="weight-light">{{ $apartment->title }}</h2>
    <h4 id="address" class="text-main weight-regular"></h4>
    
    <div class="map-show">
        <div class="map-wrapper show">
            <div class="mapid" id="mapid"></div>
        </div>        
    </div>

    {{-- latlng is here for map funcionality --}}
    <div class="latlng">
        <div id="lat">
            {{$apartment->lat}}
        </div>
        <div id="lng">
            {{$apartment->lng}}
        </div>
    </div>
    
    <div class="row info">
        <div class="info-img">
            <img class="img-fluid" src="{{ asset('storage/'. $apartment->img_url) }}" alt="{{ $apartment->title }}">
        </div>
        <div class="info-detail">
            <div class="info-detail--description">
                <h5>Descrizione</h5>
                {{ $apartment->description }}
            </div>
            <div class="info-detail--data">
                <div class="info-detail--data--details">
                    <h5>Dettaglio</h5>
                    
                    <h6><span class="weight-light">Prezzo:</span> {{$apartment->price}}€</h6>
                    <h6><span class="weight-light">Stanze:</span> {{$apartment->room_qty}}</h6>
                    <h6><span class="weight-light">Posti Letto:</span> {{$apartment->bed_qty}}</h6>
                    <h6><span class="weight-light">Bagni:</span> {{$apartment->bathroom_qty}}</h6>
                    <h6><span class="weight-light">m&sup2;:</span> {{$apartment->sqr_meters}}</h6>
                </div>
                <div class="info-detail--data--services">
                    <h5>Servizi</h5>
                    @forelse($apartment->services as $service)
                        <h6 class="weight-light">{{ $service->name }}</h6>
                    @empty
                        <h6 classe="">Nessun servizio compreso</h6>
                    @endforelse
                </div>
            </div>
        </div>
    </div>    
    @if(Auth::id() == $apartment['user_id'])
        <div class="dashboard">
            @if (session('success_message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    {{ session('success_message')}}
                </div>
            @endif
            <h4 class="section-title weight-light">Dashboard Proprietario</h4>
            <div class="dashboard-ctas">
                @if($check)
                    <button class="dashboard-ctas--btn button-main" disabled >{{ $duration - $difference }} ore rimanenti</button>
                @else
                    <a class="dashboard-ctas--btn button-main" href="{{ route('user.sponsorships', $apartment->id) }}">Sponsorizza</a>
                @endif
                <a class="dashboard-ctas--btn button-light" href="{{ route('user.apartments.edit', $apartment->id) }}">Modifica</a>
                <a class=" dashboard-ctas--btn button-dark" href="{{ route('user.stats', $apartment->id) }}">Statistiche</a> 
            
                @if($apartment->is_visible == 0)
                    <form action="{{ route('user.apartment.visibility', $apartment->id) }}" class="form" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="is_visible" value="1">
                        <input class="dashboard-ctas--btn button-shadow" type="submit" value="Pubblica">
                    </form>
                @else
                    <form action="{{ route('user.apartment.visibility', $apartment->id) }}" class="form" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="is_visible" value="0">
                        <input class="dashboard-ctas--btn button-shadow" type="submit" value="Nascondi">
                    </form>
                @endif
            
            </div>

            {{-- Message operation hide/show done --}}
            @if(Session::has('visibility'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ Session::get('visibility') == 'hidden' ? 'Appartamento nascosto' : 'Appartamento pubblicato' }}
            </div>
        @endif
        </div>
    @else
        <div class="show-message">
            <h4 class="section-title weight-light">Contatta il proprietario</h4>
            @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form method="POST" action="{{ route('send', $apartment->id) }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="La tua email"
                    @auth
                        value="{{ old('email', Auth::user()->email) }}"
                    @endauth
                    >
                </div>
                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" placeholder="Inserisci il tuo messaggio"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="send" value="Invia" class="button-main">
                </div>
            </form>
        </div>

        <div class="review">
            <h4 class="section-title weight-light">Scrivi una recensione</h4>
            @if($message = Session::get('success-review'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @Auth
            <form method="POST" action="{{ route('sendReview', $apartment->id, Auth::user()) }}">
                @if(count($errors) > 0 )
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <ul>
                            @foreach($errors ->all() as $error)
                                <li> {{ $error }}</li>  
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" placeholder="La tua recensione"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="from_id" value="{{ Auth::user()}}">
                    <input type="submit" name="send" value="Invia" class="button-main">
                </div>
            </form>
            @else
                <p>
                    <strong>
                        <a class="" href="{{ route('register') }}">Iscriviti</a> 
                    </strong>
                    o fai il 
                    <strong>
                        <a class="" href="{{ route('login') }}">Login</a> 
                    </strong>
                    per poter lasciare una recensione
                </p>
            @endauth
        </div>
    @endif
</div>
<div class="container-fluid reviews-wrapper">
    <div class="container reviews">
        <h4 class="section-title weight-light">Recensioni</h4>
        @if ( !$apartment->reviews->isEmpty()  ) 
            @foreach ($apartment->reviews as $review)
                <div class="reviews-single">

                    <div class="reviews-single--imgName">
                        <div class="reviews-single--imgName--avatar">
                            
                            @if($review->user->path_img == 'img/avatar-default.png')
                                <img class="img-fluid" src="{{ asset($review->user->path_img) }}" alt="">
                            @elseif($review->user->path_img == 'http://unsplash.it/250/250?random&gravity=center')
                                <img class="img-fluid" src="{{ $review->user->path_img }}" alt="">
                            @else
                                <img class="img-fluid" src="{{ asset('storage/' . $review->user->path_img) }}" alt="">
                            @endif
                        </div>
                        <div class="reviews-single--imgName--name">
                            <h4 class="weight-regular">{{ $review->user->first_name }}</h4>
                        </div>
                    </div>

                    <div class="reviews-single--body">
                        <div class="reviews-single--body--review">
                            <p>{{$review->body}}</p>
                        </div>
                        <div class="reviews-single--body--date">
                            <h6>{{$review->created_at->diffForHumans()}}</h6>
                            <h6 class="weight-light date-format">{{$review->created_at->format('d/m/Y')}}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Non ci sono recensioni per questo appartamento.</p>
        @endif
    </div>    
</div>    
{{-- Divider dark --}}
<div class="divider-dark"></div>

@endsection

@push('scripts')
{{-- Map --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
crossorigin=""></script>
{{-- Algolia search script for reverse geoloc --}}
<script src="https://cdn.jsdelivr.net/algoliasearch/3.31/algoliasearchLite.min.js"></script>
<script src="{{ asset("js/show-map.js") }}" defer></script>    
@endpush
