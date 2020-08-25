import $ from "jquery";
require("./bootstrap");


$(document).ready(function() { 
    
    const pack = $('.pack-basic'); // Get packs
    const amountInput = $('input#amount'); // Get Amount input
    const packInput = $('input#pack'); // Get Pack input
    const ctnCard = $('.pack-cards'); // Get Container Cards
    const ctnPay = $('.payment'); // Get container Payment

    // Choice Section
    let choiceCtn = $(".choice"); // Get Container Choice
    let choicePrice = $(".choice-price"); // Get Price Chosen
    let choiceDur = $(".choice-duration"); // Get Duration Chosen

    pack.click(function() {
        // Show/Hide Choice Container
        choiceCtn.fadeToggle();

        // Show/Hide payment container
        ctnPay.fadeToggle();

        // Get color and container

        let bgColor = $(this).css('background-color');

        // Get Price and duration
        let id = $(this).children('.pack-cards--single--id').text();
        let price = $(this).children('.pack-cards--single--price').children('.get-price').text();
        let duration = $(this).children('.pack-cards--single--duration').children('.get-duration').text();

        let cardNotSelected = $(this).siblings('.pk');

        // Print in dom (Choice) price and duration
        choicePrice.text(price);
        choiceDur.text(duration);

        // Hide package not chosen
        cardNotSelected.fadeToggle();

        // Set Color
        ctnCard.css("background-color", bgColor);

        // Set price
        amountInput.val(price);

        // Set pack id
        packInput.val(id);


        })

    });
