$(function() {
  	$('progress').each(function() {
    	var max = $(this).val();
   		$(this).val(0).animate({ value: max }, { duration: 2000, easing: 'easeOutCirc' });
	});
	
});

function finishBar() {

	$('.progress').val(100);
	$('progress').each(function() {
    	var max = $(this).val();
   		$(this).val(0).animate({ value: max }, { duration: 2000, easing: 'easeOutCirc' });
	});

}
