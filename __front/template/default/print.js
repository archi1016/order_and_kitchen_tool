
function PAGE_PRINT(o) {
	if (o) {
		o.parentNode.removeChild(o);
	}
	window.print();
	self.close();
}

function AUTO_PRINT(ap, t) {
	if ('1' != ap) {
		document.write('<div class="print"><a href="#" onclick="PAGE_PRINT(this.parentNode);">'+t+'</a></div>');
	} else {
		PAGE_PRINT(null);
	}
}