$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

	/*
	* Splits image into tiles to make a progress bar
	*/
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

		$("div."+esc(progressBarId)).click(function() {
			var idnum = $(this).attr('id').substring(1);

			$("div."+esc(progressBarId)).each(function(){
				if($(this).attr('id').substring(1) <= idnum){
					$(this).removeClass();
					$(this).addClass(progressBarId+" tile");
				}
				else{
					$(this).removeClass();
					$(this).addClass(progressBarId+" tile incomplete");
				}
			});
			updateCurrentTask(progressBarId.replace(/_/g, " "), idnum);
	  });
	};

	/*
	* Updates current value in database (called on tile click)
	*/
	function updateCurrentTask(title, value){

		var updateData = "title="+title+"&"+"newValue="+value;

		$.ajax({
			type 		: 'POST', // post request
			url 		: 'updateCurrentTask.php', // php file to handle the post
			data 		: updateData, // data to be sent
			dataType 	: 'json', // data type expected back
			encode		: true
		})
			.done(function(data) { //on ajax success
				if(data){
					$("p."+esc(space(title))).text("Up Next: " + data.nextTask);
				}
				else
					console.log("update fug up");
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
					//add new challenge to profile
					var progressBar = [
						'<label class="challenge">' + data.title,
							'<p class="'+space(data.title)+'">Up Next: '+ data.tasks +'</p>',
							'<div id="'+space(data.title)+'">',
								'<img src="img/road.jpg"/>',
							'</div>',
							'<br>',
						'</label>'
					].join("\n");
					$('#challenges').append(progressBar);
					$('#'+esc(space(data.title))).splitInTiles(data.numTasks,0);
				}
				else{
					console.log("fuggg");
					// popup error or something
				}
			});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

	/*
	* jQuery escape functions
	*
	* Escapes/replaces special characters for use in jQuery selector
	*/
	function esc(str){
		return str.replace( /(:|\.|\[|\]|,|=)/g, "\\$1" );
	}
	function space(str){
		return str.replace(/ /g, "_");
	}

	if($('.challenge > div').length > 0){ // handle cached challenges
		$('.challenge > div').each( function(){
			$(this).splitInTiles($(this).attr('data-numTasks'),$(this).attr('data-currentTask'))
		});
	}
});