<div class="modal fade" id="edit-address" tabindex="-1" role="dialog" aria-labelledby="editAddressLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit address</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('address/update') }}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="address_id">

                    <div class="form-group">
                        <label for="">Full name</label>
                        <input type="text" class="form-control" name="addressee">
                    </div>

                    <div class="form-group">
                        <label for="">Address line 1</label>
                        <input type="text" class="form-control" name="address_line1">
                    </div>

                    <div class="form-group">
                        <label for="">Address line 2</label>
                        <input type="text" class="form-control"
                               name="address_line2" placeholder="Apartment, suite, unit, building, etc.">
                    </div>

                    <div class="form-group">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="city">
                    </div>

                    <div class="form-group">
                        <label for="">State</label>
                        <input type="text" class="form-control" name="state_a2">
                    </div>

                    <div class="form-group">
                        <label for="">ZIP</label>
                        <input type="text" class="form-control" name="zip">
                    </div>

                    <div class="form-group">
                        <label for="">Phone number</label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Update">
                </form>

                <form action="{{ url('address/delete') }}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="address_id">
                    <input type="submit" class="btn btn-danger btn-block" value="Delete">
                </form>
            </div>
        </div>
    </div>
</div>