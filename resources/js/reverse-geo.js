require("./bootstrap");

/**
 * Reverse geoloc
 */
export default function cities() {
    let places = algoliasearch.initPlaces(
        process.env.MIX_PLACES_APPID,
        process.env.MIX_PLACES_APIKEY
    );
    $(".card-apt").each(function() {
        const ctx = $(this);
        // console.log($(this));
        const latFlt = parseFloat(ctx.find("#address").attr("data-lat"));
        const lngFlt = parseFloat(ctx.find("#address").attr("data-lng"));
        const addressDiv = ctx.find("#address");

        places
            .reverse({
                aroundLatLng: latFlt + "," + lngFlt
            })
            .then(updateDiv);

        function updateDiv(response) {
            var hits = response.hits;
            // The first hit is the most accurate
            var suggestion = hits[0];
            var address = "";

            // Check the response for italian names
            if (suggestion.city) {
                if (suggestion.city.it) {
                    address = `${suggestion.city.it[0]}`;
                } else if (suggestion.city.default) {
                    address = `${suggestion.city.default[0]}`;
                }
            } else if (suggestion.locale_names.default) {
                address = `${suggestion.locale_names.default[0]}`;
            } else if (suggestion.administrative) {
                address = `${suggestion.administrative[0]}`;
            } else {
                address = "Non definibile";
            }
            addressDiv.text(address);

            console.log(suggestion);
        }
    });
}

cities();
