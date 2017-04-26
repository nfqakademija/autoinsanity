// automatically submit the search form when type of sort is changed
$('#sort').change(function () {
    this.form.submit();
});

// send ajax request to pin vehicle
$('.vehicle-pin-button').click(function () {
    var button = $(this);
    var pin_action = button.hasClass('pin') ? 'pin' : 'unpin';
    button.removeClass(pin_action);
    $.ajax({
        url : Routing.generate('pin_vehicle', {id: button.val(), pinAction: pin_action}),
        type: 'POST',
        data : '',
        success: function(data) {
            if (typeof data.pin_action !== 'undefined') {
                if (data.pin_action === 'pin') {
                    button.html(data.button_text);
                } else {
                    button.html('<b>' + data.button_text + '</b>');
                }
                button.addClass(data.pin_action);
           }
        },
        error: function(data) {

        }
    });
});
