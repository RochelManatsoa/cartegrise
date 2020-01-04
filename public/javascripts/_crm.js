$(document).ready(function() {
    $('#voir_plus_button').on('click', function() { $('.voir_plus_content_car').toggle();
        $('.voir_plus_content_car').parents('.list-grid').find('.btn').toggleClass('collapsed'); });
    $('#more-details-tax').on('click', function() { $('.voir_plus_content_taxes').toggle();
        $('.voir_plus_content_taxes').parents('.list-grid').find('.btn').toggleClass('collapsed'); });
});