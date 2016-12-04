$(document).ready(function() {

  $.fn.splitInTiles = function(numTasks, currentTask) {

    var o = {x:numTasks, y:1, gap:2};
    var newCurrentTask;
    console.log("ss");

      var $container = $(this),
          width = $container.width(),
          height = $container.height(),
          $img = $container.find('img'),
          n_tiles = o.x * o.y,
          wraps = [], $wraps;

      count = 1;
      for ( var i = 0; i < n_tiles; i++ ) {
        
        if(i < currentTask){
            var tileString = '<div id="n' + count + '" class="tile"/>';
            wraps.push(tileString);
        }
        else {
          var tileString = '<div id="n' + count + '" class="tile incomplete"/>';
          wraps.push(tileString);
        }
        count++;
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
      
      $(".tile").click(function() {
          var tileId = $(this).attr('id');
          var idnum = tileId.substring(1, tileId.length);
          // alert(idnum);
          newCurrentTask = idnum;
          for(var n = 1; n <= numTasks; n++){
              
              var getElement = "#n" + n;

              if(n <= idnum){
                  $(getElement).removeClass();
                  $(getElement).addClass("tile");
              }
              else{
                  $(getElement).removeClass();
                  $(getElement).addClass("tile incomplete");
              }
          }
      });
  };

$(".barImage").splitInTiles(10,3);

});

