$(document).ready(function() { // ideas from https://scotch.io/tutorials/submitting-ajax-forms-with-jquery

		// process the form
		$('form.getChallenge').submit(function(event) {

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
					// if validation error
					if(data){
						console.log(data);
						$('.challenges').append([
							"<div>"+data.title,
							"<ul>",
								"<li>"+data.goalOne+"</li>",
								"<li>"+data.goalTwo+"</li>",
								"<li>"+data.goalThree+"</li>",
								"<li>"+data.goalFour+"</li>",
								"<li>"+data.goalFive+"</li>",
								"<li>"+data.goalSix+"</li>",
								"<li>"+data.goalSeven+"</li>",
								"<li>"+data.goalEight+"</li>",
								"<li>"+data.goalNine+"</li>",
								"<li>"+data.goalTen+"</li>",
							"</ul>",
							"</div>"
						].join("\n"));
					}
					else{
						console.log("fuggg");
						// popup error or something
					}
				});
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});

});