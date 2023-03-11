function updateAdsPlaceForm() {
    if ($('#adsplace-slider').is(':checked'))
        $('#adsplace-form-slider-block').show();
    else
        $('#adsplace-form-slider-block').hide();
}

$(document).on('change', '#adsplace-slider', function () {
    updateAdsPlaceForm();
})


var iframe = $('#banner11');
iframe.on("load", function () { //Make sure it is fully loaded
    iframe.contents().click(function (event) {
        alert(1)

    });
});


$(document).ready(function () {
    $("iframe.f12-rich-banner").each(function () {
        var iframe = $(this);
        if (iframe.data('href').length > 0)
            iframe.on("load", function () {
                iframe.contents().click(function (event) {
                    var win = window.open(iframe.data('href'), '_blank');
                    win.focus();
                });
            });

    });
});

