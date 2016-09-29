require(['jquery'], function ($) {
    $(document).ready(function(){
        $('.mobile-navigation .fa-bars').on('click', function(e){
            $('.navigation-container').toggleClass('navigation-container--mobile');
            //return false;
        });
        /*var Ps = require('perfect-scrollbar');
        require('perfect-scrollbar/jquery')($);*/
        var container = document.getElementById('sidebar');
//Ps.initialize(container);
    });
});