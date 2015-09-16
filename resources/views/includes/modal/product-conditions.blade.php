{{--General Condition Modal--}}
<div class="modal fade condition-modal" tabindex="-1" role="dialog"
     aria-labelledby="General Conditions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>{{ Config::get('product.conditions.general_condition.title') }}</h3>
            </div>
            <div class="modal-body">
                @for ($i = 0; $i < 4; $i++)
                    <dl>
                        <dt>{{ Config::get('product.conditions.general_condition')[$i] }}</dt>
                        <dd>{{ Config::get('product.conditions.general_condition.description')[$i] }}</dd>
                    </dl>
                @endfor
            </div>
        </div>
    </div>
</div>

{{--Highlights / Notes modal--}}
<div class="modal fade highlight-modal" tabindex="-1" role="dialog"
     aria-labelledby="Highlights/Notes">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal" aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>{{ Config::get('product.conditions.highlights_and_notes.title') }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.highlights_and_notes.description') }}</p>
            </div>
        </div>
    </div>
</div>

{{--Damaged pages modal--}}
<div class="modal fade damage-modal" tabindex="-1" role="dialog"
     aria-labelledby="Damaged Pages">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal" aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>{{ Config::get('product.conditions.damaged_pages.title') }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.damaged_pages.description') }}</p>
            </div>
        </div>
    </div>
</div>

{{--Broken binding modal--}}
<div class="modal fade binding-modal" tabindex="-1" role="dialog"
     aria-labelledby="Broken Binding">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-btn"
                        data-dismiss="modal"
                        aria-label="close">
                    <span id="close-span" aria-hidden="true">&times;</span>
                </button>
                <h3>{{ Config::get('product.conditions.broken_binding.title') }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ Config::get('product.conditions.broken_binding.description') }}</p>
            </div>
        </div>
    </div>
</div>