function SendForm(day) {
		document.getElementById('dayNumber').value = day;
		document.getElementById('ShowEventsByDay').submit();
};
function showModifyForm() {
    document.getElementById('hiddenModify').style.display="block";
};
function showDeleteForm() {
    document.getElementById('hiddenDelete').style.display="block";
};
function showAddForm() {
	document.getElementById('showAdd').style.display="block";
};
function sendModifyForm(id) {
	document.getElementById('modifyID').value = id;
	document.getElementById('mod').submit();
};
function sendDeleteForm(id) {
	if (confirm('Are you sure you want to delete this event?')) {
		document.getElementById('deleteID').value = id;
		document.getElementById('del').submit();
	} else {
		alert("Delete Event Aborted");
	}
}
function AddDate(date) {
	document.getElementById('datepicker').value = date;
};
function sendApproveForm(id) {
	if (confirm('Are you sure you want to approve this event?')) {
		document.getElementById('approve').value = id;
		document.getElementById('app').submit();
	} else {
		alert("Approve Event Aborted!");
	}
}

function ShowGroups() {
	alert ("display = " + document.getElementById('hiddengroups').style.display);
	if (document.getElementById('hiddengroups').style.display=="block") {
		document.getElementById('hiddengroups').style.display= "none";
	} else {
		document.getElementById('hiddengroups').style.display= "block";
	}
	alert("changed to " + document.getElementById('hiddengroups').style.display);
}