function ShowDebug(child) {
	var children = document.getElementsByClassName(child);
	for (var i = 0; i < children.length; i++) {
		children[i].style.display="block";
	}
}
function HideDebug(child) {
	var children = document.getElementsByClassName(child);
	for (var i = 0; i < children.length; i++) {
		children[i].style.display="none";
	}
}