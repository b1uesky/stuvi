<div class="modal fade condition-modal" tabindex="-1" role="dialog" aria-labelledby="General Conditions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal"
                        aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>General Conditions</h3>
            </div>
            <div class="modal-body">
                <h4>Brand New</h4>

                <p>{{ Config::get('product.conditions.general_condition.description')[0] }}</p>

                <h4>Excellent</h4>

                <p>{{ Config::get('product.conditions.general_condition.description')[1] }}</p>

                <h4>Good</h4>

                <p>{{ Config::get('product.conditions.general_condition.description')[2] }}</p>

                <h4>Acceptable</h4>

                <p>{{ Config::get('product.conditions.general_condition.description')[3] }}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade highlight-modal" tabindex="-1" role="dialog" aria-labelledby="Highlights/Notes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal"
                        aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>Highlights/Notes</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.highlights_and_notes.description_show') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade damage-modal" tabindex="-1" role="dialog" aria-labelledby="Damaged Pages">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal"
                        aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>Damaged Pages</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.damaged_pages.description_show') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade binding-modal" tabindex="-1" role="dialog" aria-labelledby="Broken Binding">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal"
                        aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>Broken Binding</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.broken_binding.description_show') }}</p>
            </div>
        </div>
    </div>
</div>