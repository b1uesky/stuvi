/**
 * Created by Desmond on 8/21/15.
 *
 * Floating alert messages.
 * http://getbootstrap.com/components/#alerts
 */

var alert = {

    defaultType: 'warning',
    validTypes: ['success', 'info', 'warning', 'danger'],

    success: function (message) {
        this.flash('success', message);
    },

    info: function (message) {
        this.flash('info', message);
    },

    warning: function (message) {
        this.flash('warning', message);
    },

    danger: function (message) {
        this.flash('danger', message);
    },

    // flash a message according to its type
    flash: function (type, message) {
        var html = $('<div class="alert alert-dismissible fade in">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            message +
            '</div>');

        // add alert type if it's valid
        if ($.inArray(type, this.validTypes)) {
            html.addClass('alert-' + type);
        } else {
            html.addClass(this.defaultType);
        }

        $('.js-alert').append(html);
    },

    // clear all alerts
    clear: function () {
        $('.js-alert').empty();
    }
}