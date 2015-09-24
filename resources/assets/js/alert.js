/**
 * Created by Desmond on 8/21/15.
 *
 * Alert messages.
 * http://getbootstrap.com/components/#alerts
 */

var Alert = function(container) {

    this.defaultType = 'warning';
    this.validTypes = ['success', 'info', 'warning', 'danger'];
    this.defaultContainer = $('.js-alert');

    this.container = container || this.defaultContainer;

    // flash a message according to its type
    this.flash = function (type, message) {
        var html = $('<div class="alert alert-dismissible fade in">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            message +
            '</div>');

        // add alert type if it's valid
        if ($.inArray(this.type, this.validTypes)) {
            html.addClass('alert-' + type);
        } else {
            html.addClass(this.defaultType);
        }

        this.container.append(html);
    },

    // clear all alerts
    this.clear = function () {
        this.container.find('.alert').remove();
    }
}