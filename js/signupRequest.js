$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

		// process the form
		$('form').submit(function(event) {

			$('#message').text(""); // clear message text
			$('input').removeClass('has-error'); // clear error coloring on input
			$('.error').text(""); // clear error text

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

					// if database error
					if(data.errors){
						
						// handle errors for username
						if (data.errors.userName) {
							// add the error class to show red input
							$('input[name=userName]').addClass('has-error');
							// add the actual error message under our input
							$('#userName-error').text(data.errors.userName);
						}

						// handle errors for email
						if (data.errors.email) {
							// add the error class to show red input
							$('input[name=email]').addClass('has-error'); 
							// add the actual error message under our input
							$('#email-error').text(data.errors.email);
						}

					} else { // account created
						$('#message').text(data.message + '<br> <a href="login.php">Login Here!</a>');
					}
				});

			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});

});