<html>
    <body>
        <p>Hi {{ $first_name }},</p>
        <p>Unfortunately, the book <strong>{{ $book_title }}</strong> you ordered on our website was cancelled by its seller. Seller has provided a message regarding to the reason of cancellation:</p>
        <blockquote>
            {{ $cancel_reason }}
        </blockquote>
        <p><a href="{{ url('order/buyer/' . $buyer_order_id) }}">Click here</a> for more details.</p>

        <p></p>
        <p>Best,</p>
        <p>Stuvi.com</p>
    </body>
</html>