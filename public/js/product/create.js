/**
 * Created by Desmond on 7/11/15.
 *
 * Page: /textbook/sell/product/{id}/create
 */

var total_images_limit = 3;

$(document).ready(function () {

    // generate an extra input element for image upload
    $('.btn-add-input').click(function () {

        // disable add image button if the limit is reached
        if ($('.upload-file').length == total_images_limit - 1 ) {
            $('.btn-add-input').addClass('disabled');
        }

        // add input field
        if ($('.upload-file').length < total_images_limit) {
            var html_block = [
                '<div class="form-group">',
                '<input type="file" name="extra-images[]" class="upload-file" />',
                '<div class="upload-error-message">The file size is too large. Please make sure the file size is under 3MB.</div>',
                '<a class="btn btn-danger btn-remove-file">Delete</a>',
                '</div>'
            ];

            // insert the block before submit button
            $(html_block.join('')).insertBefore('input[name=submit]');
        }

    });

});

// click event for delete button
$(document).on('click', '.btn-remove-file', function() {

    // remove a dynamically created input field
    $(this).parent().remove();

    // reenable add image button
    $('.btn-add-input').removeClass('disabled');

});