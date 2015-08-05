/**
 * Created by Desmond on 7/11/15.
 *
 * Page: /textbook/sell/product/{id}/create
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

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function (e) {
                // disable submit button
                $('button[type=submit]').attr('disabled', true);

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

            // form validaiton
            $('#form-product').
                formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: null,
                        invalid: null,
                        validating: null
                    },
                    fields: {
                        general_condition: {
                            validators: {
                                notEmpty: {
                                    message: 'Please select a condition'
                                }
                            }
                        },
                        highlights_and_notes: {
                            validators: {
                                notEmpty: {
                                    message: 'Please select a condition'
                                }
                            }
                        },
                        damaged_pages: {
                            validators: {
                                notEmpty: {
                                    message: 'Please select a condition'
                                }
                            }
                        },
                        broken_binding: {
                            validators: {
                                notEmpty: {
                                    message: 'Please select a condition'
                                }
                            }
                        },
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