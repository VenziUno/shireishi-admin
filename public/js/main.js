function callOverlay(element) {
    $(element).append("<div id='overlay'></div>");
    $('#overlay').show();
}

function removeOverlay() {
    $('#overlay').remove();
}