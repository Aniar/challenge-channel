$(document).ready(function() {
	$('input[name=numTasks]').keyup(generateTasks);
});

/* Generate input fields for tasks dynamically
*
* We create a long string of the data and then append it
* in one go as appends are expensive.
*/
function generateTasks(){
	$('.task').remove(); //remove previous fields
	var numTasks = $('input[name=numTasks]').val(); //number of tasks entered
	var taskFields = [];

	//add numTasks extra input fields
	for(var i = 1; i <= numTasks; i++){
		taskFields[i-1] = 
			[
			"<label class='task'>Task " + i + ": <br>",
				"<input type='text' name='task["+i+"]' required><br>",
			"</label>"
			].join("\n");
	}

	//add submission button
	taskFields.push([
		"<label class='task'> <br>",
			"<input class='btn btn-default' type='submit' value='Create Challenge'>",
		"</label>"].join("\n"));
	//append it all
	$('#challengeForm').append(taskFields.join("\n"));
}