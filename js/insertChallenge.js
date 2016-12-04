$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

	$.fn.splitInTiles = function(numTasks, currentTask) {

		var progressBarId = $(this).attr('id');
		var dim = {x:numTasks, y:1, gap:2};

		var $container = $(this),
			width = $container.width(),
			height = $container.height(),
			$img = $container.find('img'),
			n_tiles = dim.x * dim.y,
			wraps = [], $wraps;

		count = 1;
		for ( var i = 0; i < n_tiles; i++ ) {
			
			if(i < currentTask){
				var tileString = '<div id="n' + count + '" class="'+progressBarId+' tile"/>';
				wraps.push(tileString);
			}
			else {
			  var tileString = '<div id="n' + count + '" class="'+progressBarId+' tile incomplete"/>';
			  wraps.push(tileString);
			}
			count++;
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

		$("."+progressBarId.replace(":","\\:")).click(function() {
			var tileId = $(this).attr('id');
			console.log(tileId);
			var idnum = tileId.substring(1, tileId.length);
			// alert(idnum);
			for(var n = 1; n <= numTasks; n++){
				
				var getElement = "#n" + n;

				if(n <= idnum){
					$(getElement).removeClass();
					$(getElement).addClass(progressBarId+" tile");
				}
				else{
					$(getElement).removeClass();
					$(getElement).addClass(progressBarId+" tile incomplete");
				}
			}
			updateCurrentTask(progressBarId, idnum);
	  });
	};

	function updateCurrentTask(title, value){

		var updateData = "title="+title+"&"+"newValue="+value;

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
						'<label class="challenge">' + data.title,
							'<div id="'+data.title+'">',
								'<img src="img/road.jpg"/>',
							'</div>',
							'<br>',
						'</label>'
					].join("\n");
					$('#challenges').append(progressBar);
					$('#challenges').find('#'+data.title.replace(":","\\:")).splitInTiles(data.numTasks,1);
				}
				else{
					console.log("fuggg");
					// popup error or something
				}
			});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

	if($('.challenge > div').length > 0){ // make cached challenges update database on change
		$('.challenge > div').each( function(){
			$(this).splitInTiles($(this).attr('data-numTasks'),$(this).attr('data-currentTask'))
		});
	}
});