function CHECK_TO_REMOVE(m, url) {
	if (confirm(m)) {
		location.href = url;
	}
	return false;
}

function CLICK_TO_CHECKED(l) {
	var ck = l.firstChild;
	if (ck.checked) {
		l.className = '';
		ck.checked = false;
	} else {
		l.className = 'checked';
		ck.checked = true;
	}
}