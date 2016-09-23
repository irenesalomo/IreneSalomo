require(['jquery'], function ($) {
    $(document).ready(function(){
        $('.mobile-navigation .fa-bars').on('click', function(){$('.site-navigation').toggleClass('site-navigation--mobile');
        });
        /*var Ps = require('perfect-scrollbar');
        require('perfect-scrollbar/jquery')($);*/
        var container = document.getElementById('sidebar');
//Ps.initialize(container);
    });
});