$(document).ready(function() {
    //var max_file_size = 3*1024*1024; // maximum: 3MB
    //
    //$('.upload-file').bind('change', function() {
    //    //this.files[0].size gets the size of your file.
    //    var file_size = this.files[0].size;
    //
    //    if (file_size > max_file_size) {
    //        // clear the file input
    //        $(this).val('');
    //        // show error message
    //        $(this).next('.upload-error-message').show();
    //    } else {
    //        // hide error message
    //        $(this).next('.upload-error-message').hide();
    //    }
    //});

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
});