require(['jquery'], function ($) {
    $(document).ready(function(){
        require(['vendors/CustomRadioboxes.min'], function (CustomRadioboxes) {
        var customradio = new CustomRadioboxes();
        customradio.init();

        $('.tile-cat-evaluation-overlay').hide();
        $('.tile-cat-evaluation-title').on('click', function () {
          $(this).next('.tile-cat-evaluation-overlay').fadeToggle();
        });
        $('.tile-cat-evaluation-icon').on('click', function () {
          $(this).siblings('.tile-cat-evaluation-overlay').fadeToggle();
        });
      })
        var Ps = require('perfect-scrollbar');
        require('perfect-scrollbar/jquery')($);
        var container = document.getElementById('sidebar');
Ps.initialize(container);
    });
    
  
});