<div class="modal fade" id="delete-product" tabindex="-1" role="dialog" aria-labelledby="deleteProduct">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are you ABSOLUTELY sure?</h4>
            </div>
            <div class="modal-body">
                This action <strong>CANNOT</strong> be undone. This will permanently delete the book <strong class="book-title"></strong> you posted on our website.
            </div>
            <div class="modal-footer">
                <form action="{{ url('/textbook/sell/product/delete') }}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </form>
            </div>
        </div>
    </div>
</div>