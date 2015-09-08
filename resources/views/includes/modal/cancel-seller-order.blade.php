<div class="modal fade" id="cancel-seller-order" tabindex="-1" role="dialog" aria-labelledby="cancelSellerOrder">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancel Order</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('order/seller/' . $seller_order->id . '/cancel') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="">Reason for cancelling this order</label>
                        <textarea class="form-control" name="cancel_reason" rows="4" required></textarea>
                    </div>

                    <input type="submit" class="btn btn-secondary" value="Cancel order">
                </form>
            </div>
        </div>
    </div>
</div>
