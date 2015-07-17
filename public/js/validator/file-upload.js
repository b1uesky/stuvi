$(document).ready(function() {
    var max_file_size = 3*1024*1024; // maximum: 3MB

    $('.upload-file').bind('change', function() {
        //this.files[0].size gets the size of your file.
        var file_size = this.files[0].size;

        if (file_size > max_file_size) {
            // clear the file input
            $(this).val('');
            // show error message
            $(this).next('.upload-error-message').show();
        } else {
            // hide error message
            $(this).next('.upload-error-message').hide();
        }
    });
});