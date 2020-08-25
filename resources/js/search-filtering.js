require("./bootstrap");
import cities from "./reverse-geo.js";

$(document).ready(function() {
    // Handlebars instance
    var source = $("#card-template").html();
    const template = Handlebars.compile(source);

    // Algolia places instance
    const client = algoliasearch(
        '47VSO533ZH',
        'eaa5d8cf24f4fb6090811993ad43f3fd'
    );
    const index = client.initIndex("apartments");

    // Catch origin coordinates
    var origin = {
        lat: $("#origin-lat").val(),
        lng: $("#origin-lng").val()
    };

    // Filtering
    $(document).on("change", ".search-option", function() {
        var radius = $("#select-radius input:checked").val();
        var apartments = [];
        var services = getServices();
        var rooms = $("#select-rooms").val();
        var beds = $("#select-beds").val();

        // Getting ids around origin point
        index
            .search("", {
                aroundLatLng: `${origin.lat}, ${origin.lng}`,
                // aroundRadius: 1000000 // 1000 km
                aroundRadius: radius // 20 km
            })
            .then(({ hits }) => {
                hits.forEach(item => {
                    apartments.push(item["id"]);
                });

                $("#search-results").html("");

                // Request data
                var data = {
                    id: joinApartments(apartments),
                    services: services,
                    rooms: rooms,
                    beds: beds
                };

                // Calling Apartments API
                ajax(data, template);
            });
    });

    $(document).on("click", "#reset", function() {
        var apartments = [];

        index
            .search("", {
                aroundLatLng: `${origin.lat}, ${origin.lng}`,
                // aroundRadius: 1000000 // 1000 km
                aroundRadius: 20000 // 20 km
            })
            .then(({ hits }) => {
                hits.forEach(item => {
                    apartments.push(item["id"]);
                });

                clearFilters();
                $("#search-results").html("");

                // Request data
                var data = {
                    id: joinApartments(apartments),
                    services: "all",
                    rooms: 1,
                    beds: 1
                };

                // Calling Apartments API
                ajax(data, template);
            });
    });
}); // <--- End Ready

/* FUNCTIONS */

function getServices() {
    var serviceIds = [];

    $("input:checkbox").each(function() {
        var self = $(this);
        var serviceId = self.attr("data-id");

        if (self.prop("checked") == true) {
            // console.log("Checked");
            if (!serviceIds.includes(serviceId)) {
                serviceIds.push(serviceId);
            }
        } else {
            // console.log("Unchecked");
            if (serviceIds.includes(serviceId)) {
                var index = serviceIds.indexOf(serviceId);
                if (index > -1) {
                    serviceIds.splice(index);
                }
            }
        }
    });

    if (serviceIds.length != 0) {
        var services = serviceIds.join(",");
        return services;
    } else {
        services = "all";
        return services;
    }
}

function joinApartments(apartments) {
    var result = apartments.join(",");
    return result;
}

function clearFilters() {
    $("input:checkbox").each(function() {
        var self = $(this);
        self.prop("checked", false);
    });

    $("#select-beds").val("1");

    $("#select-rooms").val("1");

    $("#select-radius #20").prop("checked", true);
}

function ajax(data, template) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/apartments/",
        data: data,
        success: function(data) {
            var results = data.response;

            if (results != "empty" && results.length != 0) {
                for (let i = 0; i < results.length; i++) {
                    var item = results[i];

                    var ctx = {
                        id: item.id,
                        imgUrl: item.img_url,
                        title: item.title,
                        price: item.price,
                        rooms: item.room_qty,
                        beds: item.bed_qty,
                        bathrooms: item.bathroom_qty,
                        sqrMeters: item.sqr_meters,
                        lat: item.lat,
                        lng: item.lng,
                        reviews: item.reviews.length
                    };

                    var html = template(ctx);
                    $("#search-results").append(html);
                }
                cities();
            } else {
                $("#search-results").append("Nessun risultato trovato");
            }
        },
        error: function() {
            // console.log("Errore");
        }
    });
}
