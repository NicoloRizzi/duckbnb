require("./bootstrap");

/**
 * GEOLOC
 */
const client = algoliasearch(
    '47VSO533ZH',
    'eaa5d8cf24f4fb6090811993ad43f3fd'
);
const index = client.initIndex("apartments");

// Algolia places
var placesAutocomplete = places({
    appId: process.env.MIX_PLACES_APPID,
    apiKey: process.env.MIX_PLACES_APIKEY,
    container: document.querySelector("#address-input"),
    language: "it",
    aroundLatLngViaIP: true,
    useDeviceLocation: true
});

placesAutocomplete.on("change", changeHandle);

function changeHandle(e) {
    let lat = e.suggestion.latlng.lat;
    let lng = e.suggestion.latlng.lng;
    var apts = [];

    index
        .search("", {
            aroundLatLng: `${lat}, ${lng}`,
            // aroundRadius: 1000000 // 1000 km
            aroundRadius: 20000 // 20 km
        })
        .then(({ hits }) => {
            hits.forEach(item => {
                apts.push(item["id"]);
            });
            document.getElementById("apartmentId").value = apts;
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
            // console.log(apts);
        });
}
