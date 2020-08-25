const { isNull } = require("lodash");

require("./bootstrap");

var LeafIcon = L.Icon.extend({
    options: {
        iconSize: [48, 41],
        iconAnchor: [30, 50],
        popupAnchor: [-3, -50],
        shadowUrl: "/img/map-icons/duck-shadow.png",
        shadowSize: [66, 41],
        shadowAnchor: [30, 50]
    }
});

var orangeIcon = new LeafIcon({ iconUrl: "/img/map-icons/duck-orange.png" }),
    redIcon = new LeafIcon({ iconUrl: "/img/map-icons/duck-red.png" }),
    yellowIcon = new LeafIcon({ iconUrl: "/img/map-icons/duck-yellow.png" });
L.icon = function(options) {
    return new L.Icon(options);
};

let startLat = document.querySelector("#lat").innerHTML;
let startLng = document.querySelector("#lng").innerHTML;

const mapDiv = document.querySelector("#mapid");
let mymap = L.map(mapDiv, {
    // Map control deactivated in show
    dragging: false,
    zoomControl: false,
    scrollWheelZoom: false,
    doubleClickZoom: false
}).setView([startLat, startLng], 13);

L.tileLayer(
    "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
    {
        attribution:
            'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: "mapbox/streets-v11",
        tileSize: 512,
        zoomOffset: -1,
        accessToken: process.env.MIX_L_TOKEN
    }
).addTo(mymap);

/**
 * Reverse geoloc
 */
let places = algoliasearch.initPlaces(
    process.env.MIX_PLACES_APPID,
    process.env.MIX_PLACES_APIKEY
);

let latFlt = parseFloat(startLat);
let lngFlt = parseFloat(startLng);

places
    .reverse({
        aroundLatLng: latFlt + "," + lngFlt
    })
    .then(updateDiv);

function updateDiv(response) {
    var hits = response.hits;
    // The first hit is the most accurate
    var suggestion = hits[0];
    var addressDiv = document.querySelector("#address");
    var address = "";

    // Check the response for italian names
    if (suggestion.locale_names.it && suggestion.country.it) {
        address = `${suggestion.locale_names.it}, ${suggestion.country.it}`;
    } else if (suggestion.locale_names.default && suggestion.country.default) {
        address = `${suggestion.locale_names.default[0]}, ${suggestion.country.default}`;
    } else {
        address = "Impossibile localizzarti";
    }
    addressDiv.innerHTML = address;

    // Map icon
    L.marker([latFlt, lngFlt], { icon: yellowIcon })
        .addTo(mymap)
        .bindPopup(address)
        .openPopup();

    // console.log(suggestion);
}
