<html>
<body style="color: #000000;">
<div class="container">
    <h1>Order Details</h1>

    <div class="row" id="details1" style="font-weight: bold;">
        <p class="col-xs-12 col-sm-3">Ordered on {{ $buyer_order['created_at'] }}</p>

        <p class="col-xs-12 col-sm-4">Order #{{ $buyer_order['id'] }}</p>
    </div>

    <div class="container" id="details2" style="border: 1px solid rgba(0, 0, 0, 0.30);">
        <div class="row">
            <div class="details-shipping col-xs-12 col-sm-3" style="display: inline-block; margin-right: 30px;">
                <?php $shipping_address = $buyer_order['shipping_address'] ?>
                <h4>Shipping Address</h4>

                <p>{{ $shipping_address['addressee'] }} <br> {{ $shipping_address['address_line1'] }}
                    <br> {{ $shipping_address['city'] }}
                    , {{ $shipping_address['state_a2'] }}  {{ $shipping_address['zip'] }}</p>
            </div>
            <div class="details-payment col-xs-12 col-sm-3" style="display: inline-block; margin-right: 30px;">
                <h4>Payment Method</h4>

                <p>{{ $buyer_order['buyer_payment']['card_brand'] }}
                    **** {{ $buyer_order['buyer_payment']['card_last4'] }}</p>
            </div>
            <div class="details-pricing col-xs-12 col-sm-3 col-sm-offset-3"
                 style="display: inline-block; margin-right: 20px;">
                <h4>Order Summary</h4>

                <p>Total: ${{ $buyer_order['buyer_payment']['amount'] / 100 }}</p>
            </div>
        </div>
    </div>
    <div class="container" id="details3" style="border: 2px solid #F9AA62; margin-top: 10px; margin-bottom: 30px;">
        <div class="row row-items" style=" border-bottom: 1px solid black; margin-bottom: 10px;">
            <h3 class="col-xs-12">Items</h3>
        </div>
        @foreach ($buyer_order['products'] as $product)
            <div class="row">
                <div class="item col-xs-8">
                    <p>Title: {{ $product['book']['title'] }}</p>

                    <p>ISBN: {{ $product['book']['isbn13'] }}</p>
                    <span>Author(s): </span>
                    @foreach($product['book']['authors'] as $author)
                        <span>{{ $author['full_name'] }}</span>
                    @endforeach
                    <br>
                </div>
                <div class="price col-xs-3 col-xs-offset-1">
                    <p><b>${{ $product['price'] }}</b></p>
                </div>
            </div>
            <hr style="border-bottom: 1px solid rgba(0, 0, 0, 0.30);">
        @endforeach
    </div>

</div>
</body>
</html>