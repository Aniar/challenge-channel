// 
// // $("#exbar").slider();
// var slider = new Slider("#exbar");
// 
// $("#exbar").slider().on('slide', function(slideEvt) {
// 	alert('suppp');
// 	// var current = slideEvt.value;
// // 	slider.setValue(current);
// });

(function($, window) {

	var current = 7;
  	var _defaults = {
    x : 10, // tiles in x axis
    y : 1, // tiles in y axis
    gap: 2
  };

  $.fn.splitInTiles = function(options) {

    var o = $.extend( {}, _defaults, options );

    return this.each(function() {

      var $container = $(this),
          width = $container.width(),
          height = $container.height(),
          $img = $container.find('img'),
          n_tiles = o.x * o.y,
          wraps = [], $wraps;

      for ( var i = 0; i < n_tiles; i++ ) {
        if(i < current){
            wraps.push('<div class="tile"/>');
        }
        else if(i == current) {
        	wraps.push('<div id="next" class="tile"/>');
        }
        else {
        	wraps.push('<div id="op" class="tile"/>');
        }
      }

      $wraps = $(wraps.join(''));

      //hide original image and insert tiles in DOM
      $img.hide().after($wraps);

      //set background
      $wraps.css({
        width: (width / o.x) - o.gap,
        height: (height / o.y) - o.gap,
        marginBottom: o.gap +'px',
        marginRight: o.gap +'px',
        backgroundImage: 'url('+ $img.attr('src') +')'
      });
      
      //adjust position
      $wraps.each(function() {
        var pos = $(this).position();
        $(this).css( 'backgroundPosition', -pos.left +'px '+ -pos.top +'px' );
      });
      
      $("#op").click(function() {
  			alert( "meep" );
        $("#op").attr('id', '');
			});
			
		});
  };

}(jQuery, window));

$(".barImage").splitInTiles();

