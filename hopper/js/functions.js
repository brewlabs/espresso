var espresso = {};

espresso.adapt_callback = function(i,width,url){
  var classes = ['width-1560','width-1200','width-960','width-720','width-mobile'];

  var test1 = url.split("/");
  var value = test1[test1.length-1].split(".")[0];

  for (var j = classes.length - 1; j >= 0; j--) {
      if(classes[j] !== value){
        jQuery("body").removeClass(classes[j]);
      }
      
  }
  jQuery("body").addClass('width-'+value);

};

// remap jQuery to $
(function($){
$('document').ready(function(){
    $("ul.sf-menu").supersubs({
        minWidth: 10,
        maxWidth: 15,
        extraWidth: 1
    }).superfish({
        delay: 200,
        animation: {
            opacity: 'show',
            height: 'show'
        },
        speed: 'fast',
        autoArrows: true,
        dropShadows: true
    });

    if( typeof fluid_css !== 'undefined' && fluid_css ){
        var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
        if(width <= 760){
            espresso.set_stylesheet($css, path, sheet, 'mobile');
        }

        $(window).resize(function(){
            var $css = $('#es_grid_css'),
                path = $css.attr('href'),
                sheet = $css.attr('class'),
                width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;

            if(sheet === 'fluid' && width <= 760){
                espresso.set_stylesheet($css, path, sheet, 'mobile');
            }
            if( sheet === 'mobile' && width > 760 ){
                espresso.set_stylesheet($css, path, sheet, 'fluid');
            }
        });
    }
});

})(window.jQuery);

espresso.set_stylesheet = function($obj, path, old_sheet, new_sheet){
    $obj.attr('href',path.replace(old_sheet,new_sheet) ).removeClass(old_sheet).addClass(new_sheet);
    jQuery('body').removeClass('width-'+old_sheet).addClass('width-'+new_sheet);
};

var ADAPT_CONFIG = {
  // Where is your CSS?
  path: '/wp-content/themes/espresso/hopper/css/',

  // false = Only run once, when page first loads.
  // true = Change on window resize and page tilt.
  dynamic: true,

  // Optional callback... myCallback(i, width)
  callback: espresso.adapt_callback,

  // First range entry is the minimum.
  // Last range entry is the maximum.
  // Separate ranges by "to" keyword.
  range: [
    '0px    to 760px  = mobile.css',
    '760px  to 980px  = 720.css',
    '980px  to 1280px = 960.css',
    '1280px to 1600px = 1200.css',
    '1600px to 1920px = 1560.css',
    '1940px to 2540px = 1560.css',
    '2540px           = 1560.css'
  ]
};

