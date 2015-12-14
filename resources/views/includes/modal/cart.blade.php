@if(Auth::check())
    <?php $items = Auth::user()->cart->items; ?>
    <div class="modal" id="cart-popup" tabindex="-1" role="dialog" aria-labelledby="cart-popup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                <h4 class="modal-title text-center">Cart</h4>
            </div>

            @if(count($items) > 0)
                <div class="modal-body">
                    @foreach($items as $item)
                        <div class="row" data-product-id="{{ $item->product_id }}">
                            <div class="col-sm-3 col-xs-3">
                                <img class="img-responsive" src="{{ $item->product->book->imageSet->getImagePath('small') }}">
                            </div>
                            <div class="col-sm-7 col-xs-6">
                                <a href="{{ url('textbook/buy/product/'.$item->product->id) }}">
                                    {{ $item->product->book->title }}
                                </a>
                            </div>
                            <div class="col-sm-2 col-xs-3">
                                <span class="text-muted">${{ $item->product->price }}</span>
                                <button type="button" class="close remove-cart-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        </div>

                        <br>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <div class="pull-left margin-top-5">
                        <span class="cart-quantity">{{ count($items) }}</span>
                        <span>item(s):</span>
                        <span class="price subtotal">${{ Auth::user()->cart->subtotal() }}</span>
                    </div>

                    <a href="{{ url('order/create') }}" class="btn btn-warning">Checkout</a>
                </div>
            @else
                <div class="modal-body">
                    <h4 class="text-center">Your cart is empty...</h4>
                </div>
            @endif
        </div>
    </div>
</div>
@endif