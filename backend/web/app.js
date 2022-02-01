$(function () {
    'use strict';
    $('#videoFile').change(ev => {
        $(ev.target).closest('form').trigger('submit');
    });
})

$('[name="Video[tags]"]').tagify();

// $("table tr td input").tagify({
//     userInput: false,
//     a11y: {
//         focusableTags: false
//     }
// }).setDisabled(true);