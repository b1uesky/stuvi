$(document).ready(function () {
    $('.loading').css('visibility', 'hidden');

    $('.submit-btn').click(function () {
        $('.loading').css('visibility', 'visible');
    });

    $('.spinner-modal').on('hidden.bs.modal', function () {
        $('.loading').css('visibility', 'hidden');
    });
});

