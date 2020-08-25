let selectRooms = $("#select-rooms");
let results = $(".card");

$("#reset").on("click", function(e) {
    e.preventDefault();
    $(".card").show();
    $("input[type=checkbox]").prop("checked", false);
});

selectRooms.change(function() {
    $(".card").show();
    for (let i = 0; i < results.length; i++) {
        text = $(".card")
            .eq(i)
            .find(".rooms")
            .text();
        // console.log(text);

        if (selectRooms.val()) {
            if (text != selectRooms.val()) {
                $(".card")
                    .eq(i)
                    .hide();
            }
        }
    }
});

$('input[type="checkbox"]').click(function() {
    if ($(this).prop("checked") == true) {
        var selectedService = $(this).val();
        // console.log(selectedService);

        for (let i = 0; i < results.length - 1; i++) {
            var services = $(".card")
                .eq(i)
                .find(".nome-servizio");
            // console.log(services.length);

            for (let s = 0; s < services.length; s++) {
                var servizio = $(".card")
                    .eq(i)
                    .find(".nome-servizio")
                    .eq(s)
                    .text();
                // console.log("Servizio:", servizio);

                if (servizio == selectedService) {
                    $(".card")
                        .eq(i)
                        .show();
                    // console.log("ja");
                } else {
                    $(".card")
                        .eq(i)
                        .hide();
                }
            }
        }
    } else if ($(this).prop("checked") == false) {
        // console.log("Checkbox is unchecked.");
    }
});

/**
 * Ajax
 */
const { ajax } = require("jquery");

$(document).ready(function() {
    // setup
    const filter = $("#test");
    // const filter = $('input[type="checkbox"]');
    const apiUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/api/apartments/api";
    // console.log(apiUrl);
    // "http://127.0.0.1:8000/api/apartments/api";

    // HANDLEBARS
    // let source = $("#student-template").html();
    // let template = Handlebars.compile(source);
    // let container = $(".students");

    /**
     * Handle the selector view with handlebars
     * using the array returned with the logic of the Api/StudentController
     */
    filter.on("click", function(e) {
        e.preventDefault();

        // console.log("From Blade:", idArr.join());

        var arrInString = idArr.join();
        // console.log("Array in stringa: ", arrInString);
        var urlCombo = `${apiUrl}?filter=/${arrInString}`;
        // console.log(urlCombo);

        fetch(urlCombo)
            .then(response => response.json())
            .then(function(data) {
                // console.log(data);
            });

        $.ajax({
            url: apiUrl,
            method: "POST",
            data: {
                filter: 2
            }
        })
            .done(function(res) {
                if (res.length > 0) {
                    // console.log(res);
                    // clean
                    // container.html("");
                    // for (let i = 0; i < res.response.length; i++) {
                    //     const item = res.response[i];
                    //     let context = {
                    //         slug: item.slug,
                    //         img: item.img,
                    //         nome: item.nome,
                    //         eta: item.eta,
                    //         assunzione:
                    //             item.genere == "m" ? "assunto" : "assunta",
                    //         azienda: item.azienda,
                    //         ruolo: item.ruolo,
                    //         descrizione: item.descrizione
                    //     };
                    //     let output = template(context);
                    //     container.append(output);
                    // }
                } else {
                    // console.log(res.error);
                }
            })
            .fail(function(err) {
                // console.log("Error:", err);
            });
    });
}); //end ready
