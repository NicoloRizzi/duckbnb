@extends('layouts.app')

@section('content')


<div class="container-fluid sponsorship-page">

    @if (session('success_message'))
    <div class="alert alert-success">
        {{ session('success_message')}}
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="pack container-fluid">
        <div class="pack-cards container-fluid">
            
            <div class="pack-cards--title">
                <h2 class="weight-light">Sponsorizza</h2>
            </div>


            @foreach($sponsorship as $sponsor)
            <a class="pack-cards--single pk pk-{{$loop->iteration}} pack-basic">
                <span class="pack-cards--single--id">{{ $sponsor->id }}</span>        
                <span class="pack-cards--single--price price"> <span class="get-price">{{ $sponsor->price }}</span>€</span>
                <span class="pack-cards--single--duration duration"> <span class="get-duration">{{ $sponsor->duration }}</span> ore.</span>
            </a>
            @endforeach

        </div>
    </div>

    <div class="slogan container-fluid">
        <div class="slogan-title container">
            <h3 class="weight-light text-main">Scegli fra i nostri pacchetti</h3>
        </div>
        <div class="slogan-subtitle container">
            <p>Metti in vetrina il tuo appartamento ed aumenta le tue vendite, grazie alle sponsorizzazioni.</p>
        </div>
    </div>

    <div class="choice-payment container">
        <div class="choice">
            <h4>Hai scelto il pacchetto da 
                {{-- Insert Price with jQuery --}}
                <span class="choice-price text-main"></span>€.
            </h4>
            <h5>
                L'appartamento <span class="text-main">{{$apartment->title }}</span> sarà in sponsorizzazione per
                {{-- Insert Duration with jQuery --}} 
                <span class="choice-duration text-main"></span> ore.
            </h5>
    
            <p>Qui sotto puoi completare il pagamento.</p>
        </div>
    
        <div class="payment">
            <div class="payment--form">
                <form method="post" id="payment-form" action="{{ route('user.sponsorships.checkout', $apartment->id) }}">
                    @csrf
                    <section>
                        <label for="amount">
                            <div class="input-wrapper amount-wrapper">
                                <input type="hidden" id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="0">
                            </div>
                        </label>
        
                        <label for="pack">
                            <div class="input-wrapper amount-wrapper">
                                <input type="hidden" id="pack" name="pack" type="tel" min="1" placeholder="pack" value="0">
                            </div>
                        </label>
        
                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>
                    </section>
        
                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                    <button class="button-main" type="submit">
                        Paga
                    </button>
                </form>
            </div>
            
        </div>
    </div>
    
</div>

  
<script>

    var form = document.querySelector('#payment-form');
    var client_token = "{{ $token }}";

    braintree.dropin.create({
    authorization: client_token,
    selector: '#bt-dropin',
    paypal: {
        flow: 'vault'
    }
    }, function (createErr, instance) {
    if (createErr) {
        console.log('Create Error', createErr);
        return;
    }
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        instance.requestPaymentMethod(function (err, payload) {
        if (err) {
            console.log('Request Payment Method Error', err);
            return;
        }

        // Add the nonce to the form and submit
        document.querySelector('#nonce').value = payload.nonce;
        form.submit();
        });
    });
    });
</script>
@endsection

@push('scripts')
<script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
<script src="{{ asset('js/sponsorship.js')}}"></script>
@endpush