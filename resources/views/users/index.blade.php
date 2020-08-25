@extends('layouts.app')

@section('content')

@if (session('apartment_deleted'))
    <div class="alert alert-success">
        Appartamento <strong>{{ session('apartment_deleted') }}</strong> cancellato!
    </div>
@endif

<div class="container dashboard">

    <div class="row dashbord-welcome mb-5">
        <p>Ciao <span class="text-main dashboard-welcome--username">{{!empty(Auth::user()->first_name) ? Auth::user()->first_name : Auth::user()->email}}</span>, benvenuto nella tua dashboard.</p>
    </div>
    {{-- Secondary Nav --}}
    <nav class="row dashboard-nav">
       <ul>
            <li class="dashboard-nav--link apt select">
                <a href="#">I tuoi appartamenti</a>
            </li>
            <li class="dashboard-nav--link msg">
                <a href="#">Messaggi</a>
            </li>
       </ul>
    </nav>

    <div class="dashboard-apts">
        <div class="dashboard-apts--title">
            <h2>I tuoi appartamenti</h2>
            <a href="{{ route('user.apartments.create') }}" class="button-main">Aggiungi</a>
        </div>
        <div class="dashboard-apts--apt">
            @if(count($apartments) > 0)
                @foreach ($apartments as $apartment)
                <div class="card-apt">
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
                    <div class="card-apt--buttons">
                        <div class="card-apt--buttons-visibility">
                            @if($apartment->is_visible == 0)
                                <form action="{{ route('user.apartment.visibility', $apartment->id) }}" class="form" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="is_visible" value="1">
                                    <button class="dashboard-ctas--btn vis" type="submit">
                                        <ion-icon name="eye-off-outline"></ion-icon>
                                </button>
                                </form>
                            @else
                                <form action="{{ route('user.apartment.visibility', $apartment->id) }}" class="form" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="is_visible" value="0">
                                    <button class="dashboard-ctas--btn not-vis" type="submit" >
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                    
                                </form>
                            @endif
                        </div>
                        <div class="card-apt--buttons-delete">
                            <form action="{{ route('user.apartments.destroy', $apartment->id) }}" method="POST" >
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                        <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </form>
                        </div>
                    </div>    
                </div>
                @endforeach
            @else
                <div class="no-apt">
                    <p>Non hai nessun appartamento, aggiungine uno!</p>
                </div>
            @endif
        </div>
    </div>

    <div class="dashboard-messages" style="display: none;">
        <div class="dashboard-messages--title">
            <h2>Messaggi</h2>
        </div>
        <div class="dashboard-messages--msgs">
            @foreach($apartments as $apartment)
            @if(!$apartment->messages->isEmpty())
            <div class="dashboard-messages--msgs--singleCtn">
                
                <div class="dashboard-messages--msgs--singleCtn--apt">
                    <div class="dashboard-messages--msgs--singleCtn--apt-nameApt">
                        <h5 class="weight-light text-main">{{ $apartment->title }}</h5>
                    </div>
    
                    @foreach($apartment->messages as $message)
                    <div class="dashboard-messages--msgs--singleCtn--apt-messages">
                        <div class="dashboard-messages--msgs--singleCtn--apt-messages--from">
                            <span class="text-main">Mittente: </span><a href="mailto:{{ $message->mail_from }}">{{ $message->mail_from }}</a>
                        </div>
                        <div class="dashboard-messages--msgs--singleCtn--apt-messages--body">
                            <p>
                                {{ $message->body }}
                            </p>
                        </div>
                        <div class="dashboard-messages--msgs--singleCtn--apt-messages--date">
                            <h5 class="weight-light">{{ $message->created_at->format('d/m/Y - ' . 'H:i') }}</h5>       
                        </div>
                    </div>
                    @endforeach        
                </div> 
            </div>
            @endif
            @endforeach
        </div>
   
        
    </div>
</div>

    
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/algoliasearch/3.31/algoliasearchLite.min.js"></script>
<script src="{{ asset('js/dashboard-nav.js')}}"></script>
<script src="{{ asset("js/reverse-geo.js") }}" defer></script>
@endpush
