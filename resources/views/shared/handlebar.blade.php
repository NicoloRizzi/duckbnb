<script id="card-template" type="text/x-handlebars-template">
    <div class="card-apt">
        <a href="{{ url('apartments') }}/@{{id}}" class="card-apt--img">
            <img class="img-fluid" src="{{ asset('storage') }}/@{{ imgUrl }}" alt="">
        </a>
        <div class="card-apt--location">
            <h5 class="weight-regular">
                Recensioni (<span class="text-main">@{{ reviews }}</span>)
                
            </h5>
            <h5 id="address" class="weight-regular text-main" data-lat="@{{ lat }}" data-lng="@{{ lng }}"> Città </h5>
        </div>
        <div class="card-apt--title">
            <h4 class="weight-regular">@{{ title }}</h4>
        </div>
        <div class="card-apt--price">
            <h4 class="weight-regular"> <span class="text-main weight-bold">@{{ price }}€</span> a notte</h4>
        </div>
    </div>      
</script>

