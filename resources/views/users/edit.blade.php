@extends('layouts.app')

@section('content')

<div class="container edit">
    <div class="edit--title">
        <h2 class="mb-4">Modifica <span class="text-main">{{ $apartment->title }}</span></h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="edit--form">
        <form action="{{ route("user.apartments.update", $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PATCH")
    
            <div class="form-group">
                <input class="form-control" type="text" name="title" id="title" value="{{ old("title", $apartment->title) }}" placeholder="Inserisci un titolo" required maxlength="150" pattern="[A-z0-9À-ž\s]+">
            </div>
    
            <div class="form-group">
                <textarea class="form-control" name="description" id="description" placeholder="Inserisci una descrizione" required maxlength="1500">{{ old("description", $apartment->description) }}</textarea>
            </div>
    
            <div class="form-group">
                <label for="price">Prezzo per notte</label>
                <input class="form-control" type="number" min="1" max="10000" name="price" id="price" value="{{ old("price", $apartment->price) }}" placeholder="€">
            </div>
            
            <div class="form-group">
                @isset($apartment->img_url)
                    <h6>Immagine corrente</h6>
                    <img style="display:block;" width="200" src="{{ asset('storage/'. $apartment->img_url) }}" alt="{{ $apartment->title }}">
                @endisset
                <label for="img_url">Inserisci una nuova immagine</label>
                <div class="box">

                    <input type="file" name="img_url" id="img_url" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                    
					<label for="img_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Inserisci una nuova foto&hellip;</span></label>
				</div>
            </div>
    
            <div class="form-group">
                <label for="room_qty">N° di stanze :</label>
                <input class="form-control" type="number" min="1" max="10000" name="room_qty" id="room_qty" value="{{ old("room_qty", $apartment->room_qty) }}" placeholder="Inserisci il numero di stanze">
            </div>
    
            <div class="form-group">
                <label for="bathroom_qty">N° di bagni :</label>
                <input class="form-control" type="number" min="1" max="10000" name="bathroom_qty" id="bathroom_qty" value="{{ old("bathroom_qty", $apartment->bathroom_qty) }}" placeholder="Inserisci il numero di bagni">
            </div>
    
            <div class="form-group">
                <label for="bed_qty">N° di letti :</label>
                <input class="form-control" type="number" min="1" max="10000" name="bed_qty" id="bed_qty" value="{{ old("bed_qty", $apartment->bed_qty) }}" placeholder="Inserisci il numero di letti">
            </div>
    
            <div class="form-group">
                <label for="sqr_meters">N° di m<sup>2</sup> :</label>
                <input class="form-control" type="number" min="1" max="10000" 
                name="sqr_meters" id="sqr_meters" value="{{ old("sqr_meters", $apartment->sqr_meters) }}" 
                placeholder="Inserisci il numero di metri quadri">
            </div>
    
    
            <div class="form-group">
                <label for="activeStatus">Visibilità</label>
                <select id="activeStatus" name="is_visible">
                    <option value="1" selected>Pubblica</option>
                    <option value="0">Nascondi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address-input">Indirizzo</label>
                <input id="address-input" class="form" placeholder="Modifica indirizzo completo"/>
            </div>
    
            <div class="edit--form--services">
                @foreach ($services as $service)
                    <div class="form-check form-check-inline">
                        <input name="services[]" type="checkbox" class="form-check-input" id="service-{{ $loop->iteration }}" value="{{ $service->id}}" 
                        @if($apartment->services->contains($service->id))
                            checked
                        @endif
                        >
                        <label class="form-check-label" for="service-{{ $loop->iteration }}">{{ $service->name }}</label>
                    </div>
                @endforeach
            </div>
    
    
            <input type="hidden" id="lat" name="lat" value="{{ old("lat", $apartment->lat) }}">
            <input type="hidden" id="lng" name="lng" value="{{ old("lng", $apartment->lng) }}"> 
    
            <input class="button-main" type="submit" value="Salva Modifiche">
    
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset("js/place-create.js") }}" defer></script>    
<script src="{{ asset("js/file-input.js") }}" defer></script>      
@endpush
