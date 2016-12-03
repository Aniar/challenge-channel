$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

		// process the form
		$('form').submit(function(event) {

			$('#message').text(""); // clear message text
			$('.error').text(""); // clear error text

			// get data from form
			var formData = $(this).serialize();
			// field being updated
			var field = $(this).find('input:first').attr('name');
			formData += "&name="+field;

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
					// if validation error
					if(data)
						$('#message').text(field+" updated");
					else
						$('p.error').text("Error updating information");
				}).fail(function(data){console.log(data);});
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});

});