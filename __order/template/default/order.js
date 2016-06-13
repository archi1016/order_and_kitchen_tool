
function CHECK_TO_REMOVE(m, url) {
	if (confirm(m)) {
		location.href = url;
	}
	return false;
}

function INC_MEAL_QTY() {
	var o = document.getElementById('mealqty');
	var v = parseInt(o.value);
	
	if (v < 100) {
		v++;
		o.value = v;
	}
	return false;
}

function DEC_MEAL_QTY() {
	var o = document.getElementById('mealqty');
	var v = parseInt(o.value);
	
	if (v > 1) {
		v--;
		o.value = v;
	}
	return false;
}

function CHECK_FLAVOR_BOX(a) {
	var c = a.previousSibling;
	
	if (c.checked) {
		a.className = '';
		c.checked = false;
	} else {
		a.className = 'checked';
		c.checked = true;
	}
	return false;
}

function CHECK_ADDITIONAL_BOX(a) {
	var c = a.previousSibling;
	
	if (c.checked) {
		a.className = '';
		c.checked = false;
	} else {
		a.className = 'checked';
		c.checked = true;
	}
	return false;
}

function SET_PAY_VALUE(a) {
	var p = document.getElementById('orderpay');
	var t = parseInt(document.getElementById('ordertotal').value);
	var c = document.getElementById('orderchange');
	var v = a.innerText;

	if ('C' != v) {
		v = parseInt(v.replace('+', '')) + parseInt(p.value);
		if (v > 10000) v = 0;
		p.value = v;
		c.value = parseInt(v) - t;
	} else {
		p.value = '0';
		c.value = 0 - t;
	}
	return false;
}

function LAUNCH_REFRESH_TIMER() {
	setInterval('COUNTDOWN_REFRESH_TIMER()', 1000);
}

function COUNTDOWN_REFRESH_TIMER() {
	HOME_REFRESH_SECONDS--;
	if (0 >= HOME_REFRESH_SECONDS) {
		location.href = HOME_REFRESH_LOCATION;
	}
}
