$(document).ready(function () {
    $('.icon-mobile-menu').click(function(){
        $('#sidebar-container').toggleClass('show');
        $('.new-header').toggleClass('show');
    });
    var $paramPopup = $('#sidebar-container');
    $(document).mouseup(function (e) {
        if (!$paramPopup.is(e.target) && $paramPopup.has(e.target).length === 0){
            if($('#sidebar-container').is(':visible')){
                $('#sidebar-container').removeClass('show');
                $('.new-header').removeClass('show');
            }
        }
    }); 
    $('.toggle-menu-connected').click(function(){
        $('.bloc-connected').toggleClass('show');
    });
    var $menuConnected = $('.toggle-menu-connected');
    $(document).mouseup(function (e) {
        if (!$menuConnected.is(e.target) && $menuConnected.has(e.target).length === 0){
            if($('.toggle-menu-connected').is(':visible')){
                $('.toggle-menu-connected').removeClass('show');
                $('.bloc-connected').removeClass('show');
            }
        }
    });
});