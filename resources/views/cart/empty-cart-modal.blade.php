{{-- Modal to pop up if the user's cart is empty. --}}

@section('empty-cart-modal')
    <div class="empty-cart-modal-container" style="z-index: 99999;">
        <div class="modal fade empty-cart-modal" id="empty-cart-modal" tabindex="-1" role="dialog" aria-labelledby="EmptyCart"
                style= "">
            {{-- position: fixed; top: 0; bottom: 0; right: 0; left: 50%; outline: none;" data-backdrop="false--}}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- close button -->
                        <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close" id="close-empty-cart-btn">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- header -->
                        <h4>Your Cart is Empty</h4>
                    </div>
                    <div class="modal-body">
                        <p>You have no books in your shopping cart. <i class="fa fa-frown-o fa-lg"></i></p>

                        <p><a class="btn primary-btn" href="{{url('/textbook')}}">Shop now!</a></p>
                    </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default modal-close"
                               onclick="document.getElementById('close-empty-cart-btn').click()"
                                aria-label="close">Close</button>
                   </div>
                </div>
            </div>
        </div>
    </div>
@show