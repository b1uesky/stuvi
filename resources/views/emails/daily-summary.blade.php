<p>A brief summary for today ({{ \Carbon\Carbon::today()->toDateString() }}):</p>

<p>
    # users signed up: <strong>{{ $count_signed_up }}</strong><br>
    # books created: <strong>{{ $count_books }}</strong><br>
    # products posted: <strong>{{ $count_products }}</strong><br>
    # buyer orders: <strong>{{ $count_buyer_orders }}</strong><br>
    # seller orders: <strong>{{ $count_seller_orders }}</strong>
</p>

<p>
    <a href="https://stuvi.com">Stuvi</a> |
    <a href="https://stuvi.com/admin">Admin Panel</a> |
    <a href="https://analytics.google.com/analytics/web/">Google Analytics</a>
</p>