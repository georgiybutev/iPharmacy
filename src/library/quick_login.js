/*
 * Quick Login
 * Catch digit user input.
 * Attach the result to the submit button.
 */

var pinCode = new Array();
var asterix = " *";
var i = 0;

// Get the user input - quick login code
// Display the input in the designated field
// Stop only when the quick login code string length eqauls four
function getDigit(digit) {
	pinCode[i] = digit;	
	i++;
	if(pinCode.length == 4){
		document.quick_login.ten.value = pinCode[0] + 
		pinCode[1] + pinCode[2] + pinCode[3] + asterix;
	}
}

// Reset the user input display
function reseto() {
	location.reload();
}