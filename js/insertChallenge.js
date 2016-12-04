$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

	$.fn.splitInTiles = function(numTasks, currentTask) {

	var dim = {x:numTasks, y:1, gap:2};

      var $container = $(this),
        width = $container.width(),
        height = $container.height(),
        $img = $container.find('img'),
        n_tiles = dim.x * dim.y,
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
      width: (width / dim.x) - dim.gap,
      height: (height / dim.y) - dim.gap,
      marginBottom: dim.gap +'px',
      marginRight: dim.gap +'px',
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

	// process the form
	$('form.bindChallenge').submit(function(event) {

		// get data from form
		var formData = $(this).serialize();
		// post to location designated in form
		var postURL = $(this).attr('action');

		// process the form
		$.ajax({
			type 		: 'POST', // post request
			url 		: postURL, // php file to handle the post
			data 		: formData, // data to be sent
			dataType 	: 'json', // data type expected back
			encode		: true
		})
			.done(function(data) { //on ajax success
				if(data){
					var progressBar = [
						'<div id="'+data.title+'" class="challenge">',
							'<img src="img/color-run.jpg"/>',
						'</div>'
					].join("\n");
					$('#challenges').append(progressBar);
					$('#challenges').find('#'+data.title.replace(":","\\:")).splitInTiles(data.numTasks,1);
					//TODO: update database on click
				}
				else{
					console.log("fuggg");
					// popup error or something
				}
			});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

	if($('div.challenge').length > 0){ // make cached challenges update database on change
		$('div.challenge').each( function(){
			$(this).splitInTiles($(this).attr('data-numTasks'),$(this).attr('data-currentTask'))
		});
		$('div.challenge').change(function(){
			updateCurrentTask($(this).attr('id'),$(this).val());
		});
	}


	function updateCurrentTask(id, value){

		var updateData = "title="+id+"&"+"newValue="+value;

		//add title

		$.ajax({
			type 		: 'POST', // post request
			url 		: 'updateCurrentTask.php', // php file to handle the post
			data 		: updateData, // data to be sent
			dataType 	: 'json', // data type expected back
			encode		: true
		})
			.done(function(data) { //on ajax success
				if(data)
					console.log("Database updated");
			});
	}
});