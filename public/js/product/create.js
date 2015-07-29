/**
 * Created by Desmond on 7/11/15.
 *
 * Page: /textbook/sell/product/{id}/create
 * Dropzone: http://www.dropzonejs.com
 */

Dropzone.options.formProduct = { // The camelized version of the ID of the form element

    url: '/textbook/sell/product/store',
    method: 'post',

    autoProcessQueue: false,
    previewsContainer: '#dropzone-img-preview',
    clickable: '#dropzone-img-preview',
    addRemoveLinks: true,
    dictRemoveFile: 'Remove',

    uploadMultiple: true,
    parallelUploads: 3,
    maxFiles: 3,
    maxFilesize: 3,


    // The setting up of the dropzone
    init: function() {
        var myDropzone = this;

        // First change the button to actually tell Dropzone to process the queue.
        this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });

        // When a file is added to the list
        this.on("addedfile", function() {
            $('.dz-message').hide();
        });

        // When a file is removed from the list
        this.on("removedfile", function() {
            // enable file upload
            this.setupEventListeners();

            $('#dropzone-img-preview').removeClass('dz-unclickable');
            $('#dropzone-img-preview').addClass('dz-clickable');
        });

        // When all files in the list are removed and the dropzone is reset to initial state.
        this.on("reset", function() {
            $('.dz-message').show();
        });

        // When the number of files accepted reaches the maxFiles limit.
        this.on("maxfilesreached", function() {
            // disable file upload
            this.removeEventListeners();

            $('#dropzone-img-preview').removeClass('dz-clickable');
            $('#dropzone-img-preview').addClass('dz-unclickable');

        });

        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function() {
            // Gets triggered when the form is actually being sent.
            // Hide the success button or the complete form.
        });
        this.on("successmultiple", function(files, response) {
            // Gets triggered when the files have successfully been sent.
            // Redirect user or notify of success.
            console.log(response);

            window.location.replace(response.redirect);
        });
        this.on("errormultiple", function(files, response) {
            // Gets triggered when there was an error sending the files.
            // Maybe show form again, and notify user of error
            console.log(response);
        });
    }
}