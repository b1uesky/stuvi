<div class="modal fade" id="delete-buyer-order" tabindex="-1" role="dialog" aria-labelledby="deleteBuyerOrder">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you ABSOLUTELY sure?</h4>
            </div>
            <div class="modal-body">
                This action <strong>CANNOT</strong> be undone. This will permanently cancel your order.
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger cancel-order-btn" href="/order/buyer/cancel/{{ $buyer_order->id }}"
                   role="button">Cancel order</a>
            </div>
        </div>
    </div>
</div>