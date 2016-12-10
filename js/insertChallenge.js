$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

	/*
	* Splits image into tiles to make a progress bar
	*/
	$.fn.splitInTiles = function(numTasks, currentTask, tasks) {

		var progressBarId = $(this).attr('id');
		var dim = {x:numTasks, y:1, gap:2};

		var $container = $(this).children('.progressBar'),
			width = $container.width(),
			height = $container.height(),
			$img = $container.find('img'),
			n_tiles = dim.x * dim.y,
			wraps = [], $wraps;

		count = 1;
		for ( var i = 0; i < n_tiles; i++ ) {
			
			if(i < currentTask){
				var tileString = '<div title="'+tasks[count]+'" id="n' + count + '" class="'+progressBarId+' tile"/>';
				wraps.push(tileString);
			}
			else {
			  var tileString = '<div title="'+tasks[count]+'" id="n' + count + '" class="'+progressBarId+' tile incomplete"/>';
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
		var pic = new Image();
		var imgWidth;
		var imgHeight;
		pic.src = $(".progressBar img").attr('src');
		pic.onload = function() {
			imgWidth = pic.width;
			imgHeight = pic.height;
			$wraps.each(function() {
				var pos = $(this).position();
				$(this).css( 'backgroundPosition', -(pos.left+(imgWidth/4)) +'px '+ -(pos.top+(imgHeight/2)) +'px' );
			});
		}

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
		$(".tile").tooltip();
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
				if(!data.error){
					if(data.nextTask)
						$("p."+esc(space(title))).text("Up Next: " + data.nextTask);
					else{
						alert("You've completed challenge "+title+", congratulations!\n"+
								"It will be moved to your completed challenges.");
						$("#"+esc(space(title))).remove();
						$("#completed").append('<li>'+title+'</li>');

						//TODO: Give choice to leave challenge where it is (needs database interactions)
						// var remove = confirm("You've completed challenge "+title+", congratulations!\n"+
						// 		"Press OK to move to completed challenges or CANCEL to leave it where it is.");
						// if(remove){
						// 	$("#"+esc(space(title))).remove();
						// 	$("#completed").append('<li>'+title+'</li>');
						// }
						// else
						// 	$("p."+esc(space(title))).text("You've finished this challenge!");
					}
				}
				else
					console.log(data.error);
			});
	}

	function removeChallenge(event){
		//get challenge to remove
		var deleteId = $(this).parent().attr('id').replace(/_/g, " ");
		// get data from form
		var formData = "title="+deleteId;
		//remove challenge
		$("#"+esc(space(deleteId))).remove();

		// delete challenge from database
		$.ajax({
			type 		: 'POST', // post request
			url 		: 'removeChallenge.php', // php file to handle the post
			data 		: formData, // data to be sent
			dataType 	: 'json', // data type expected back
			encode		: true
		}).done(function(data){
			if(data.error)
				console.log(data.error);
		});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
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
				if(!data.error){
					//add new challenge to profile
					var progressBar = [
						'<div id="'+space(data.title)+'"" class="challenge">' + data.title,
							'<p class="'+space(data.title)+'">Up Next: '+ data.tasks[1] +'</p>',
							'<div class="progressBar">',
								'<img src="img/road.jpg"/>',
							'</div>',
							'<form action="removeChallenge.php" method="post" class="removeChallenge">',
								'<input type="submit" value="Remove" class="btn btn-default">',
							'</form>',
							'<br>',
						'</div>'
					].join("\n");
					$('#challenges').append(progressBar);
					$('#'+esc(space(data.title))).splitInTiles(data.numTasks,0, data.tasks);
					$('form.removeChallenge').submit(function(event) {
						//get challenge to remove
						var deleteId = $(this).parent().attr('id').replace(/_/g, " ");
						// get data from form
						var formData = "title="+deleteId;
						//remove challenge
						$("#"+esc(space(deleteId))).remove();

						// delete challenge from database
						$.ajax({
							type 		: 'POST', // post request
							url 		: 'removeChallenge.php', // php file to handle the post
							data 		: formData, // data to be sent
							dataType 	: 'json', // data type expected back
							encode		: true
						}).done(function(data){
							if(data.error)
								console.log(data.error);
						});
						// stop the form from submitting the normal way and refreshing the page
						event.preventDefault();
					});
				}
				else{
					console.log(data.error);
					// popup error or something
				}
			});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

	$('form.removeChallenge').submit(function(event) {

		//get challenge to remove
		var deleteId = $(this).parent().attr('id').replace(/_/g, " ");
		// get data from form
		var formData = "title="+deleteId;
		//remove challenge
		$("#"+esc(space(deleteId))).remove();

		// delete challenge from database
		$.ajax({
			type 		: 'POST', // post request
			url 		: 'removeChallenge.php', // php file to handle the post
			data 		: formData, // data to be sent
			dataType 	: 'json', // data type expected back
			encode		: true
		}).done(function(data){
			if(data.error)
				console.log(data.error);
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

	
	if($('.challenge').length > 0){ // handle cached challenges
		$('.challenge').each( function(){
			$(this).splitInTiles(
				$(this).children(".progressBar").attr('data-numTasks'),
				$(this).children(".progressBar").attr('data-currentTask'),
				JSON.parse($(this).children(".progressBar").attr('data-tasks'))
			);
		});
	}
});