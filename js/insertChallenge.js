$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

		// process the form
		$('form').submit(function(event) {

			// get data from form
			var formData = $(this).serialize();
			// post to location designated in form
			var postURL = $('form').attr('action'); //getChallenge.php

			// process the form
			$.ajax({
				type 		: 'POST', // post request
				url 		: postURL, // php file to handle the post
				data 		: formData, // data to be sent
				dataType 	: 'json', // data type expected back
				encode		: true
			})
				.done(function(data) { //on ajax success
					// if validation error
					if(data){
						// dynamically add
					}
					else{
						// challenge not found error
					}
				});
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});

});