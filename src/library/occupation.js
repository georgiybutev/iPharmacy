/*
 * Medical Occupation Roles
 * The user can select medical role based on previous occupation selection.
 * Change the reCaptcha theme.
 */

// String arrays displayed to the user.

var allied = [
				"Arts Therapy",
				"Chiropody",
				"Podiatry",
				"Dietetics",
				"Orthoptics",
				"Occupational Therapy",
				"Paramedic",
				"Physiotherapy",
				"Prosthetics",
				"Radiography",
				"Language Therapy"];

var ambulance = [
				"Ambulance Care Assistant",
				"Ambulance Technician",
				"Call Handler",
				"Emergency Care Assistant",
				"Emergency Medical Dispatcher",
				"Paramedic",
				"Senior Paramedic",
				"PTS Controller"];

var dental = [
				"Dentist",
				"Dental Nurse",
				"Dental Hygienist",
				"Dental Therapist",
				"Dental Technician"];

var doctor = [
				"GP",
				"MD"];

var management = [
				"General Manager",
				"Estate Manager",
				"Practice Manager",
				"Information Manager",
				"Financial Manager",
				"Clinical Manager",
				"Human Resources"];

var nusring = [
				"Adult Nurse",
				"Mental Health Nurse",
				"Children\'s Nurse",
				"Learning Disability Nurse",
				"District Nurse",
				"Neonatal Nurse",
				"Health Visitors",
				"Practice Nurses",
				"Prison Nurses",
				"School Nurses",
				"Theater Nurses",
				"Healthcare Assistant"];

var pharmacy = [
				"Hospital Pharmacist",
				"Community Pharmacist",
				"Pharmacy Technician",
				"Pharmacy Assistant"];

var psychological = [
				"Clinical Psychologist",
				"Health Psychologist",
				"Counselling Psychologist",
				"Forensic Psychologist",
				"Psychotherapist",
				"High Intensity Therapist"];

var other = [
				"Administrator",
				"Estates",
				"Corporate Services",
				"Clinical Support Services",
				"Domestic Services",
				"Reception"];

// String arrays used for data submission.

var alliedValue = [
				"Arts Therapy",
				"Chiropody",
				"Podiatry",
				"Dietetics",
				"Orthoptics",
				"Occupational Therapy",
				"Paramedic",
				"Physiotherapy",
				"Prosthetics",
				"Radiography",
				"Language Therapy"];

var ambulanceValue = [
				"Ambulance Care Assistant",
				"Ambulance Technician",
				"Call Handler",
				"Emergency Care Assistant",
				"Emergency Medical Dispatcher",
				"Paramedic",
				"Senior Paramedic",
				"PTS Controller"];

var dentalValue = [
				"Dentist",
				"Dental Nurse",
				"Dental Hygienist",
				"Dental Therapist",
				"Dental Technician"];

var doctorValue = [
				"GP",
				"MD"];

var managementValue = [
				"General Manager",
				"Estate Manager",
				"Practice Manager",
				"Information Manager",
				"Financial Manager",
				"Clinical Manager",
				"Human Resources"];

var nusringValue = [
				"Adult Nurse",
				"Mental Health Nurse",
				"Children\'s Nurse",
				"Learning Disability Nurse",
				"District Nurse",
				"Neonatal Nurse",
				"Health Visitors",
				"Practice Nurses",
				"Prison Nurses",
				"School Nurses",
				"Theater Nurses",
				"Healthcare Assistant"];

var pharmacyValue = [
				"Hospital Pharmacist",
				"Community Pharmacist",
				"Pharmacy Technician",
				"Pharmacy Assistant"];

var psychologicalValue = [
				"Clinical Psychologist",
				"Health Psychologist",
				"Counselling Psychologist",
				"Forensic Psychologist",
				"Psychotherapist",
				"High Intensity Therapist"];

var otherValue = [
				"Administrator",
				"Estates",
				"Corporate Services",
				"Clinical Support Services",
				"Domestic Services",
				"Reception"];

// Dynamically change the medical roles drop down list.

function getRole(selected){
	// Clear initial drop down values.
	document.registration.role.options.length = 0;
	switch (selected){
		case 'allied':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < allied.length; i++){
				document.registration.role.options[i] = new Option(allied[i], alliedValue[i], false, false);
			}
			break;
		case 'ambulance':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < ambulance.length; i++){
				document.registration.role.options[i] = new Option(ambulance[i], ambulanceValue[i], false, false);
			}
			break;
		case 'dental':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < dental.length; i++){
				document.registration.role.options[i] = new Option(dental[i], dentalValue[i], false, false);
			}
			break;
		case 'doctor':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < doctor.length; i++){
				document.registration.role.options[i] = new Option(doctor[i], doctorValue[i], false, false);
			}
			break;
		case 'management':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < management.length; i++){
				document.registration.role.options[i] = new Option(management[i], managementValue[i], false, false);
			}
			break;
		case 'nusring':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < nusring.length; i++){
				document.registration.role.options[i] = new Option(nusring[i], nusringValue[i], false, false);
			}
			break;
		case 'pharmacy':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < pharmacy.length; i++){
				document.registration.role.options[i] = new Option(pharmacy[i], pharmacyValue[i], false, false);
			}
			break;
		case 'psychological':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < psychological.length; i++){
				document.registration.role.options[i] = new Option(psychological[i], psychologicalValue[i], false, false);
			}
			break;
		case 'other':
			// Iterate over occupation roles array to fill the drop down list.
			for (var i = 0; i < other.length; i++){
				document.registration.role.options[i] = new Option(other[i], otherValue[i], false, false);
			}
			break;
		default:
			document.registration.role.options[0] = new Option('No Related Roles', 'noroles', false, false);
	}
	//alert(selected);
}

// Change the reCaptcha theme.

var RecaptchaOptions = {
	theme : 'clean'
};