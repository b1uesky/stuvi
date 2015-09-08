<div class="modal fade" id="cancel-seller-order" tabindex="-1" role="dialog" aria-labelledby="cancelSellerOrder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancel Order</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('order/seller/cancel') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="seller_order_id">

                    <div class="form-group">
                        <textarea class="form-control" name="cancel_reason" rows="4" placeholder="Reason for cancellation. We will also email this message to the buyer." required></textarea>
                    </div>

                    <input type="submit" class="btn btn-secondary" value="Cancel order">
                </form>
            </div>
        </div>
    </div>
</div>
