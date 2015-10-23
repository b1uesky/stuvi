<h3>Confirm your delivery address</h3>

<ul class="list-group">

    @foreach(Auth::user()->addresses as $address)
        <li class="list-group-item">
            <ul class="no-bullet no-padding-left">
                <li>{{ $address->addressee }}</li>
                <li>
                    {{ $address->address_line1 }}
                    @if($address->address_line2)
                        , {{ $address->address_line2 }}
                    @endif
                </li>
                <li>{{ $address->city }}, {{ $address->state_a2 }} {{ $address->zip }}</li>
                <li>
                    {{ $address->phone_number }}
                    <a href="#edit-address" data-toggle="modal"
                       data-address_id="{{ $address->id }}"
                       data-addressee="{{ $address->addressee }}"
                       data-address_line1="{{ $address->address_line1 }}"
                       data-address_line2="{{ $address->address_line2 }}"
                       data-city="{{ $address->city }}"
                       data-state_a2="{{ $address->state_a2 }}"
                       data-zip="{{ $address->zip }}"
                       data-phone_number="{{ $address->phone_number }}">
                        Edit
                    </a>
                </li>
                <br>
                <li>
                    @if($address->is_default)
                        <button class="btn btn-primary disabled">Selected address</button>
                    @else
                        <form action="{{ url('address/select') }}" method="post" class="no-margin-bottom">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="selected_address_id" value="{{ $address->id }}">
                            <input type="submit" class="btn btn-primary" value="Use this address">
                        </form>
                    @endif
                </li>
            </ul>
        </li>
    @endforeach

    {{-- Add a new address --}}
    <li class="list-group-item">
        <a href="#add-address" data-toggle="modal">
            <span class="glyphicon glyphicon-plus"></span> Add a new address
        </a>
    </li>
</ul>


@include('includes.modal.add-address')
@include('includes.modal.edit-address')