/**
 * Created by Desmond on 8/3/15.
 *
 * http://stuvi.app/textbook/sell/product/{id}/edit
 */

$(document).ready(function () {

    Dropzone.options.formProduct = { // The camelized version of the ID of the form element

        url: '/textbook/sell/product/update',
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
            var countFiles = 0;
            var countMockFiles = 0;

            // retrieve product images that already exists on the server
            // and display them in the preview image container
            $.ajax({
                type: 'GET',
                url: '/textbook/sell/product/getImages',
                data: {
                    product_id: $('[name="product_id"]').val()
                },
                dataType: 'json',
                success: function (response, status) {

                    if (response.success) {
                        var images = response.images;

                        for (var i = 0; i < images.length; i++) {

                            var bucket = 'https://s3.amazonaws.com/stuvi-product-img/';

                            // https://github.com/enyo/dropzone/wiki/FAQ#how-to-show-files-already-stored-on-server
                            // Create the mock file
                            var mockFile = {
                                //name: 'MockFile',
                                //size: 12345,
                                productImageID: images[i].id,
                                isMockFile: true
                            }

                            // Call the default addedfile event handler
                            myDropzone.emit("addedfile", mockFile);

                            // And optionally show the thumbnail of the file:
                            myDropzone.emit("thumbnail", mockFile, bucket + images[i].medium_image);

                            // Make sure that there is no progress bar, etc...
                            myDropzone.emit("complete", mockFile);
                        }

                        // correct maxFiles
                        myDropzone.options.maxFiles = myDropzone.options.maxFiles - images.length;

                    } else {
                        console.log(response);
                    }
                },
                error: function (xhr, status, errorThrown) {
                    console.log(status);
                    console.log(errorThrown);
                }
            });

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function (e) {
                // disable submit button
                $('button[type=submit]').attr('disabled', true);

                // if there is a new image added
                if (countFiles - countMockFiles > 0) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();

                    myDropzone.processQueue();
                } else if (countFiles > 0) {
                    $('#form-product').submit();
                } else {
                    myDropzone.disable();

                    $('.alert.alert-danger').remove();

                    var error = '<div class="alert alert-danger" role="alert">' +
                        '<span class="sr-only">Error:</span>Need at least one front cover image.' +
                        '</div>';

                    $(error).insertBefore('#form-product');
                }
            });

            // When a file is added to the list
            this.on("addedfile", function (file) {
                $('.dz-message').hide();
                countFiles = countFiles + 1;

                if (file.isMockFile) {
                    countMockFiles = countMockFiles + 1;
                }
            });

            // When a file is removed from the list
            this.on("removedfile", function (file) {
                countFiles = countFiles - 1;

                if (file.isMockFile) {
                    countMockFiles = countMockFiles - 1;
                }

                // enable file upload
                this.setupEventListeners();

                $('#dropzone-img-preview').removeClass('dz-unclickable');
                $('#dropzone-img-preview').addClass('dz-clickable');

                // if we remove a mock file, we need to increment maxFiles by 1
                if (file.isMockFile) {
                    myDropzone.options.maxFiles = myDropzone.options.maxFiles + 1;

                    // delete the file from the server
                    $.ajax({
                        type: 'POST',
                        url: '/textbook/sell/product/deleteImage',
                        data: {
                            _token: $('[name="csrf_token"]').attr('content'),
                            productImageID: file.productImageID
                        },
                        dataType: 'json',
                        success: function (response, status) {
                            if (response.success) {
                                console.log('Deleted successfully.');
                            } else {
                                console.log(response);
                            }
                        },
                        error: function (xhr, status, errorThrown) {
                            console.log(status);
                            console.log(errorThrown);
                        }
                    });
                }
            });

            // When all files in the list are removed and the dropzone is reset to initial state.
            this.on("reset", function () {
                if (countFiles == 0) {
                    $('.dz-message').show();
                }
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
                    console.log(response);
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

            // form validation
            $('#form-product').
                formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: null,
                        invalid: null,
                        validating: null
                    },
                    fields: {
                        price: {
                            validators: {
                                notEmpty: {
                                    message: 'The price is required'
                                },
                                numeric: {
                                    message: 'The price must be a numeric number'
                                },
                                greaterThan: {
                                    message: 'The is not a valid price',
                                    inclusive: false,
                                    value: 0
                                }
                            }
                        }
                    }
                });

        }
    }

});