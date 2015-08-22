<!-- terms of use -->
<div class="modal fade terms-modal" tabindex="-1" role="dialog" aria-labelledby="Terms of Use" id="terms-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn" data-dismiss="modal"
                        aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>Terms of Use</h3>
            </div>
            <div class="modal-body">
                @include('includes.tos-content')
            </div>
        </div>
    </div>
</div>


<!-- privacy notice -->
<div class="modal fade privacy-modal" tabindex="-1" role="dialog" aria-labelledby="Privacy Notice" id="privacy-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn" data-dismiss="modal"
                        aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>Privacy Notice</h3>
            </div>
            <div class="modal-body">
                @include('includes.privacy-content')
            </div>
        </div>
    </div>
</div>