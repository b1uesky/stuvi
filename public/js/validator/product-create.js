$(document).ready(function() {

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