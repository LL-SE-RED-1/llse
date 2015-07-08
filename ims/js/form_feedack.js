/**
 * Created by lds on 6/12/15.
 */

function show_positive_message() {
    $(".ui.positive.message").transition('scale in');
    setTimeout(function() {
        $(".ui.positive.message").transition('scale out');
    }, 1500);
};


function show_negative_message() {
    $(".ui.negative.message").transition('scale in');
    setTimeout(function() {
        $(".ui.negative.message").transition('scale out');
    }, 3000);
};
