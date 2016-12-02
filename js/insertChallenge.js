$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

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
						var slider = new Slider("#exbar",{
							'id': data.title,
							'ticks': data.ticks,
							'ticks_labels': data.ticks_labels
						});
						// slider.on('change', function(change){
						// 	console.log(change.newValue);
						// 	// ajax request here
						// });
					}
					else{
						console.log("fuggg");
						// popup error or something
					}
				});
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});


		$('input.challenge').change(function(){

			challenge = "title="+$(this).attr('id');
			newValue = "newValue="+$(this).val();
			data = challenge+"&"+newValue;

			//add title

			$.ajax({
				type 		: 'POST', // post request
				url 		: 'updateCurrentTask.php', // php file to handle the post
				data 		: data, // data to be sent
				dataType 	: 'json', // data type expected back
				encode		: true
			})
				.done(function(data) { //on ajax success
					if(data)
						console.log("Database updated");
				});
		});
});