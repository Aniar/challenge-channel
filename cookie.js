if(navigator.cookieEnabled){
	if(getCookie("loggedIn")){
		window.location = "loginPage.php";
	}
}

function getCookie(name) { //stolen from https://www.sitepoint.com/how-to-deal-with-cookies-in-javascript/
	var regexp = new RegExp("(?:^" + name + "|;\s*"+ name + ")=(.*?)(?:;|$)", "g");
	var result = regexp.exec(document.cookie);
	return (result === null) ? null : result[1];
}
