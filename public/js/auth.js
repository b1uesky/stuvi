/**
 * Created by Desmond on 7/23/15.
 */

$(document).ready(function() {
    $('#form-register').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            first_name: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'The first name is required'
                    },
                    stringLength: {
                        max: 30,
                        message: 'The first name must be less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'The first name can only consist of alphabetical'
                    }
                }
            },
            last_name: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'The last name is required'
                    },
                    stringLength: {
                        max: 30,
                        message: 'The last name must be less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'The last name can only consist of alphabetical'
                    }
                }
            },
            email: {
                trigger: 'blur',
                validators: {
                    remote: {
                        url: 'auth/email',
                        data: function(validator, $field, value) {
                            return {
                                email: validator.getFieldElements('email').val()
                            };
                        },
                        type: 'POST',
                        message: 'The email address already exsits'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    }
                }
            }
        }
    });
});