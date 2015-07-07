$(document).ready(function() {
    var max_file_size = 3000000; // maximum: 3MB

    $('.upload-file').bind('change', function() {
        //this.files[0].size gets the size of your file.
        var file_size = this.files[0].size;

        if (file_size > max_file_size) {
            $(this).val('');
            $('.upload-error-message').text('The file size is too large. Please make sure the file size is under 3MB.');
        }
    });
});