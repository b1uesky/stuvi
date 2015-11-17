$(document).ready(function() {
    // Book general condition
    $('#book-general-condition-popover').popover({
        content: '<p><strong>Like new: </strong>No missing or damaged pages, no creases or tears, and no underlining/highlighting of text or writing in the margins. Very minimal wear and tear.</p>' +
        '<p><strong>Good: </strong>The majority of pages are undamaged with minimal creasing or tearing. Minimal underlining or highlighting. No missing pages.</p>' +
        '<p><strong>Acceptable: </strong>A book with obvious wear. Possible writing in margins, possible underlining and highlighting of text, but no missing pages or anything that would compromise the legibility or understanding of the text.</p>',
        html: true,
        trigger: 'hover',
        placement: 'auto'
    });

    // Book highlights/notes
    $('#book-highlights-notes-popover').popover({
        content: 'The approximate number of pages that contain highlighted/underlined material or notes.',
        trigger: 'hover',
        placement: 'auto'
    });

    // Book damaged pages
    $('#book-damaged-pages-popover').popover({
        content: 'The approximate number of damaged pages. This includes folded pages, partially torn pages, and water damage.',
        trigger: 'hover',
        placement: 'auto'
    });

    // Book broken binding
    $('#book-broken-binding-popover').popover({
        content: 'The book binding is severely damaged or not.',
        trigger: 'hover',
        placement: 'auto'
    });

    // Book Trade-In Program
    $('#book-trade-in-popover').popover({
        content: 'By joining the Stuvi Book Trade-in program, you will have an option to sell the book directly to Stuvi. ' +
        'Our team will review your book, offer a trade-in price and send you an email with details once we approved your book. ' +
        'Of course, you decide to take the deal or not. ' +
        'This process may take at most 2 days. You can change this option later.',
        trigger: 'hover',
        placement: 'auto'
    });

    // Receiving payment
    $('#receiving-payment-popover').popover({
        content: '<p><strong>PayPal: </strong>You will receive payment through PayPal after your book is delivered to the buyer. A PayPal account is required.</p>' +
        '<p><strong>Cash: </strong>You will get paid by cash once our courier has picked up your book.</p>',
        html: true,
        trigger: 'hover',
        placement: 'auto'
    });
});