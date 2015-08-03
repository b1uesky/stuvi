/**
 * Created by Desmond on 8/3/15.
 */

$(document).ready(function () {

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
        init: function () {
            var myDropzone = this;

            // get product images that already exists
            $.ajax({
                type: 'GET',
                url: '/textbook/sell/product/getImages',
                data: {
                    product_id: $('[name="product_id"]').val()
                },
                dataType: 'json',
                success: function (response, status) {

                    if (response.success) {
                        //console.log(response.images);
                        var images = response.images;

                        for (var i = 0; i < images.length; i++) {

                            var bucket = 'https://s3.amazonaws.com/stuvi-product-img/';

                            var mockFile = {
                                name: 'Filename',
                                size: 12345
                            }

                            // Call the default addedfile event handler
                            myDropzone.emit("addedfile", mockFile);

                            // And optionally show the thumbnail of the file:
                            myDropzone.emit("thumbnail", mockFile, bucket + images[i].medium_image);

                            // Make sure that there is no progress bar, etc...
                            myDropzone.emit("complete", mockFile);

                            // If you use the maxFiles option, make sure you adjust it to the
                            // correct amount:
                            var existingFileCount = i + 1; // The number of files already uploaded
                            myDropzone.options.maxFiles = myDropzone.options.maxFiles - existingFileCount;
                        }
                    } else {

                    }
                },
                error: function (xhr, status, errorThrown) {
                    console.log(status);
                    console.log(errorThrown);
                }
            });

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function (e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            // When a file is added to the list
            this.on("addedfile", function () {
                $('.dz-message').hide();
            });

            // When a file is removed from the list
            this.on("removedfile", function () {
                // enable file upload
                this.setupEventListeners();

                $('#dropzone-img-preview').removeClass('dz-unclickable');
                $('#dropzone-img-preview').addClass('dz-clickable');
            });

            // When all files in the list are removed and the dropzone is reset to initial state.
            this.on("reset", function () {
                $('.dz-message').show();
            });

            // When the number of files accepted reaches the maxFiles limit.
            this.on("maxfilesreached", function () {
                // disable file upload
                this.removeEventListeners();

                $('#dropzone-img-preview').removeClass('dz-clickable');
                $('#dropzone-img-preview').addClass('dz-unclickable');

            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function () {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });
            this.on("successmultiple", function (files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                console.log(response);

                if (response.success == true) {
                    window.location.replace(response.redirect);
                } else {
                    // TODO: error message display
                    $('.alert.alert-danger').remove();

                    var error = '<div class="alert alert-danger" role="alert">';

                    for (var field in response.fields) {
                        error = error + '<span class="sr-only">Error:</span>' + response.fields[field] + '<br>'
                    }

                    error = error + '</div>';

                    $(error).insertBefore('#form-product');
                }


            });
            this.on("errormultiple", function (files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                console.log(response);
            });
        }
    }

});