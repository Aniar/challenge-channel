$(document).ready(function() {

  $.fn.splitInTiles = function(numTasks, currentTask) {

    var o = {x:numTasks, y:1, gap:2};
    console.log("ss");

      var $container = $(this),
          width = $container.width(),
          height = $container.height(),
          $img = $container.find('img'),
          n_tiles = o.x * o.y,
          wraps = [], $wraps;

      for ( var i = 0; i < n_tiles; i++ ) {
        if(i < currentTask){
            wraps.push('<div class="tile"/>');
        }
        else if(i == currentTask) {
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
  };

$(".barImage").splitInTiles(10,3);

});

