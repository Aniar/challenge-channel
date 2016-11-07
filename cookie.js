if(navigator.cookieEnabled){
	if(getCookie("loggedIn")){
		window.location = "http://wilfredwallis.com/csc210/profile.php";
	}
}

function getCookie(name) { //taken from https://www.sitepoint.com/how-to-deal-with-cookies-in-javascript/
	var regexp = new RegExp("(?:^" + name + "|;\s*"+ name + ")=(.*?)(?:;|$)", "g");
	var result = regexp.exec(document.cookie);
	return (result === null) ? null : result[1];
}