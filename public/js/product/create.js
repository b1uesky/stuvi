/**
 * Created by Desmond on 7/11/15.
 *
 * Page: /textbook/sell/product/{id}/create
 */

$(document).ready(function () {

    initializeDropzone();

    $('.btn-to-details').click(function() {
        $('.details').removeClass('hidden');
        $('.ready').removeClass('hidden');

        $('html, body').animate({
            scrollTop: $(".details").offset().top
        }, 500);
    });

    $('.btn-to-ready').click(function() {
        $('html, body').animate({
            scrollTop: $(".ready").offset().top
        }, 500);
    });

    function initializeDropzone() {
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
            maxFilesize: 5,

            // The setting up of the dropzone
            init: function () {
                // disable submit button
                $('input[type=submit]').attr('disabled', true);

                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
                this.element.querySelector("input[type=submit]").addEventListener("click", function (e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });

                // When a file is added to the list
                this.on("addedfile", function () {
                    $('.dz-message').hide();
                    $('input[type=submit]').attr('disabled', false);
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
                    $('input[type=submit]').attr('disabled', true);
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

                        alert.clear();

                        for (var field in response.fields) {
                            var message = response.fields[field];
                            alert.warning(message);
                        }

                        // reenable file upload
                        for (var i = 0; i < files.length; i++) {
                            files[i].status = Dropzone.QUEUED;
                        }

                    }
                });
                this.on("errormultiple", function (files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                    console.log(response);
                });
            }
        }
    }
});