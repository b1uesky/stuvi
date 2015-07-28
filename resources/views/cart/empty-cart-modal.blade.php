{{-- Modal to pop up if the user's cart is empty. --}}

@section('empty-cart-modal')
    <div class="empty-cart-modal-container" style="z-index: 99999;">
        <div class="modal fade empty-cart-modal" id="empty-cart-modal" tabindex="-1" role="dialog" aria-labelledby="EmptyCart">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- close button -->
                        <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- header -->
                        <h4>Your Cart is Empty</h4>
                    </div>
                    <div class="modal-body">
                        <p>You have no products in your shopping cart!</p>
                        <p><a href="{{url('/textbook')}}">Start filling it up!</a></p>
                    </div>
                   <div class="modal-footer">
                       <button class="btn btn-default" data-dismiss="modal">Close</button>
                   </div>
                </div>
            </div>
        </div>
    </div>
@show