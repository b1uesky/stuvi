$(document).ready(function() {
    // show info about the Stuvi Book Trade-In Program
    $('#book-trade-in-popover').popover({
        content: 'By joining the Stuvi Book Trade-in program, you will have an option to sell the book directly to Stuvi. ' +
        'Our team will review your book, offer a trade-in price and send you an email with details once we approved your book. ' +
        'Of course, you decide to take the deal or not. ' +
        'This process may take at most 2 days. You can change this option later.',
        trigger: 'hover'
    });
});