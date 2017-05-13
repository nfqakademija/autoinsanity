// send ajax request to pin vehicle search
$('.vehicle-search-pin-button').click(function () {
    var button = $(this);
    var pin_action = button.hasClass('pin') ? 'pin' : 'unpin';
    button.removeClass(pin_action);
    $.ajax({
        url : Routing.generate('pin_vehicle_search', {id: button.val(), pinAction: pin_action}),
        type: 'POST',
        data : '',
        success: function(data) {
            if (typeof data.pin_action !== 'undefined') {
                if (data.pin_action === 'pin') {
                    button.html('<span class="glyphicon glyphicon-heart-empty"></span> ' + data.button_text);
                } else {
                    button.html('<span class="glyphicon glyphicon-heart"></span> <b>' + data.button_text + '</b>');
                }
                button.addClass(data.pin_action);
            }
        },
        error: function(data) {

        }
    });
});

// $(document).on('click', function (e) {
//     $('[data-toggle="popover"],[data-original-title]').each(function () {
//         //the 'is' for buttons that trigger popups
//         //the 'has' for icons within a button that triggers a popup
//         if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
//             (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
//         }
//
//     });
// });
