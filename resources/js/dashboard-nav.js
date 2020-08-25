import $ from "jquery";
require("./bootstrap");

$(document).ready(function() {
    const aptNav = $(".dashboard-nav--link"); // Get Nav Link
    const aptsCtn = $(".dashboard-apts"); // Get Apartments Container
    const msgsCtn = $(".dashboard-messages"); // Get Messages Container

    // console.log(aptNav);
    // console.log(aptsCtn);
    // console.log(msgsCtn);

    aptNav.click(function() {
        if ($(this).hasClass("apt")) {
            // Select Color Label
            selectNav($(this));

            aptsCtn.show();
            msgsCtn.hide();
        } else if ($(this).hasClass("msg")) {
            // Select Color Label
            selectNav($(this));

            msgsCtn.show();
            aptsCtn.hide();
        }
    });
});

// Function

function selectNav(selected) {
    if (!selected.hasClass("select")) {
        selected.siblings().removeClass("select");

        selected.addClass("select");
    }
}
