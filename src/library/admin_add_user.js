// Check whether text field was left empty
function checkIfEmpty(HTMLElement) {
	var element = HTMLElement;
	// The string length should be longer than 0
	if(element.value == 0){
		alert(element.id + " field cannot be left blank!");
	}
}

// Generate username combining the user supplied forename and surname
function generateUsername() {
	var forename = document.getElementById("forname").value;
	var surname = document.getElementById("surname").value;
	forename = forename.toLowerCase();
	surname = surname.toLowerCase();
	// Concatenate the surname and only the fisr character from the forename
	var username = surname + forename.charAt(0);
	document.getElementById("username").value = username;
}

// Generate password combining the user supplied surname, the current date, and lenght of surname string
function generatePassword() {
	var surname = document.getElementById("surname").value;
	surname = surname.toUpperCase();
	var length = surname.length;
	// JS Date object return only digits rather than string
	// This is necessary to convert the integer values to days of the week
	var d = new Date();
	var date = d.getDay();
	switch(date){
		case 0:
			date = "Monday";
			break;
		case 1:
			date = "Tuesday";
			break;
		case 2: 
			date = "Wednesday";
			break;
		case 3:
			date = "Thursday";
			break;
		case 4:
			date = "Friday";
			break;
		case 5:
			date = "Saturday";
			break;
		case 6:
			date = "Sunday";
			break;
		default:
			date = "Apocalypse";
			break;
	}

	var password = date + length + surname;
	document.getElementById("password").value = password;
}

// Generate quick login pin code based on the JS random Math class
function generatePin() {
	// Cannot be a negative number pin code
	var min = 0;
	// Cannot be more than four digits long
	var max = 9999;
	// Multiply by 1000 to get four digit number
	var pin = Math.floor((Math.random()*10000) + 1); // Only between 0 and 1.
	document.getElementById("pin").value = pin;
}