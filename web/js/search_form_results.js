// automatically submit the search form when type of sort is changed
$('#sort').change(function () {
    this.form.submit();
});

// send ajax request to pin vehicle
$('.vehicle-pin-button').click(function () {
    var button = $(this);
    $.ajax({
        url : Routing.generate('pin_vehicle', {id: button.val(), pin_action: 'pin'}),
        type: 'POST',
        data : '',
        success: function(html) {
            button.html(html);
        },
        error: function(html) {

        }
    });
});
