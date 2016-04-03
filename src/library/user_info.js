/*
 * Get User Application Information
 * Execute on page load
 */

// On page load call ini function
window.onload = ini;

var all;
var cookies;
var javaInstalled;
var browser;
var result;

// Get browser variables
function ini() {
	all = navigator.appVersion;
	cookies = navigator.cookieEnabled;
	javaInstalled = navigator.javaEnabled();
	filterResults();
}

// Get more client PC variables
function filterResults() {
	browser = getBrowserVersion();
	displayBrowserVersion();
	os = getOSVersion();
	displayOSVersion();
	osBits = getOSBits();
	displayOSBits();
	displayJavaSupport();
	displayCookiesSupport();

}

// Browser version is returned in cryptic manner
// This function translates the browser code name
function getBrowserVersion() {
	if (all.match(/MSIE 10.0/i) != null) {
		result = "Internet Explorer 10";
	} else if(all.match(/MSIE 9.0/i) != null) {
		result = "Internet Explorer 9";
	} else if(all.match(/MSIE 8.0/i) != null) {
		result = "Internet Explorer 8";
	} else if(all.match(/MSIE 8.0/i) != null) {
		result = "Internet Explorer 8";
	} else if(all.match(/MSIE 7.0/i) != null) {
		result = "Internet Explorer 7";
	} else if(all.match(/MSIE 6.0/i) != null) {
		result = "Internet Explorer 6";
	} else if(all.match(/Firefox/i) != null) {
		result = "Mozilla Firefox";
	} else if(all.match(/Chrome/i) != null) {
		result = "Google Chrome";
	} else if(all.match(/Chromium/i) != null) {
		result = "Google Open Source Chromium";
	} else if(all.match(/Safari/i) != null) {
		result = "Safari";
	} else if(all.match(/Opera/i) != null) {
		result = "Opera";
	} else {
		result = "Unknown";
	}

	return result;
}

// Operating System version is returned in cryptic manner
// This function translates the OS version
function getOSVersion() {
	if (all.match(/Windows NT 6.2/i) != null){
		result = "Windows 8";
	} else if (all.match(/Windows NT 6.1/i) != null){
		result = "Windows 7";
	} else if (all.match(/Windows NT 6.0/i) != null){
		result = "Windows Vista";
	} else if (all.match(/Windows NT 5.2/i) != null){
		result = "Windows Server 2003";
	} else if (all.match(/Windows NT 5.1/i) != null){
		result = "Windows XP";
	} else if (all.match(/Windows NT 5.0/i) != null){
		result = "Windows 2000";
	} else if (all.match(/Windows 98/i) != null){
		result = "Windows 98";
	} else if (all.match(/Macintosh/i) != null) {
		result = "Mac OS X";
	} else {
		result = "Unknown";
	}

	return result;
}

// Operating System bits (32/63) is returned in cryptic manner
// This function translates the os bits
function getOSBits() {
	if ((all.match(/Win64/i) != null) || 
		(all.match(/IA64/i) != null) || 
		(all.match(/x64/i) != null)) {
		result = "64 Bit CPU";
	} else if (all.match(/WOW64/i) != null) {
		result = "64 Bit CPU | 32 Bit IE";
	} else {
		result = "32 Bit CPU";
	}

	return result;
}

// Display the results into the designated HTML divisions
function displayBrowserVersion() {
	document.getElementById("browser").innerHTML = browser;
}

function displayOSVersion() {
	document.getElementById("os").innerHTML = os;
}

function displayOSBits() {
	document.getElementById("osbits").innerHTML = osBits;
}

function displayJavaSupport() {
	if(javaInstalled){
		document.getElementById("javaInstalled").innerHTML = "Yes";
	} else {
		document.getElementById("javaInstalled").innerHTML = "No";
	}
}

function displayCookiesSupport() {
	if (cookies) {
		document.getElementById("cookies").innerHTML = "Yes";
	} else {
		document.getElementById("cookies").innerHTML = "No";
	}
}