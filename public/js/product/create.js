/**
 * Created by Desmond on 7/11/15.
 */

var total_images_limit = 3;

$(document).ready(function () {

    // generate an extra input element for image upload
    $('.btn-add-input').click(function () {

        // disable add image if the limit is reached
        if ($('.upload-file').length == total_images_limit - 1 ) {
            $('.btn-add-input').addClass('disabled');
        }

        if ($('.upload-file').length < total_images_limit) {
            var html_block = [
                '<div class="form-group">',
                '<input type="file" name="extra-image" class="upload-file" />',
                '<div class="upload-error-message">The file size is too large. Please make sure the file size is under 3MB.</div>',
                '<a class="btn btn-danger btn-remove-file">Remove</a>',
                '</div>'
            ];

            $(html_block.join('')).insertBefore('input[name=submit]');
        }

    });

});

// remove a dynamically created input field and reenable add image button
$(document).on('click', '.btn-remove-file', function() {

    $(this).parent().remove();
    $('.btn-add-input').removeClass('disabled');

});