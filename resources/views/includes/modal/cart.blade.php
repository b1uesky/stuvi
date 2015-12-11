<?php $items = Auth::user()->cart->items; ?>
<div class="modal" id="cart-popup" tabindex="-1" role="dialog" aria-labelledby="cart-popup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cart</h4>
            </div>
            <div class="modal-body">
                @forelse($items as $item)
                    <div class="row" data-product-id="{{ $item->product_id }}">
                        <div class="col-xs-3">
                            <img class="img-responsive" src="{{ $item->product->book->imageSet->getImagePath('small') }}">
                        </div>
                        <div class="col-xs-7">
                            <a href="{{ url('textbook/buy/product/'.$item->product->id) }}">
                                {{ $item->product->book->title }}
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <span class="text-muted">${{ $item->product->price }}</span>
                            <button type="button" class="close remove-cart-popup-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                @empty
                    <h4>Your cart is empty...</h4>
                @endforelse
            </div>
            <div class="modal-footer">
                <div class="pull-left margin-top-5">
                    <span class="cart-quantity">{{ count($items) }}</span>
                    <span>item(s):</span>
                    <span class="price subtotal">${{ Auth::user()->cart->subtotal() }}</span>
                </div>

                <a href="{{ url('order/create') }}" class="btn btn-warning">Checkout</a>
            </div>
        </div>
    </div>
</div>
