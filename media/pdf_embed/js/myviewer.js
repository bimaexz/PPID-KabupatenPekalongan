function tjPdfjsHideBtns() {
	var pdfjspreview = document.getElementsByClassName("pdfjspreview")[0];
	var pdfjspreviewBody = pdfjspreview.contentDocument;
	var element;

	if (parseInt(tjPdfJsDownload) === 0) {
		element = pdfjspreviewBody.getElementById('download');
		secondaryDownload = pdfjspreviewBody.getElementById('secondaryDownload');

		if (element) {
			element.parentNode.removeChild(element);
		}

		if (secondaryDownload) {
			secondaryDownload.parentNode.removeChild(secondaryDownload);
		}
	}
	if (parseInt(tjPdfJsPrint) === 0) {
		element = pdfjspreviewBody.getElementById('print');
		secondaryPrint = pdfjspreviewBody.getElementById('secondaryPrint');

		if (element) {
			element.parentNode.removeChild(element);
		}
		if (secondaryPrint) {
			secondaryPrint.parentNode.removeChild(secondaryPrint);
		}
	}
}
document.addEventListener('DOMContentLoaded', (event) => {
	setTimeout(function () {tjPdfjsHideBtns()}, 3000);
	setTimeout(function () {tjPdfjsHideBtns()}, 10000);
});
