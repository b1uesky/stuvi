@extends('admin')

@section('title', 'Home')

@section('content')
    <div class="container">
        <div class="row">
            {{-- User panel --}}
            <div class="col-xs-12 col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">User</div>

                    <table class="table table-hover">
                        <tr>
                            <th>Count</th>
                            <td>{{ $user_count }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Product panel --}}
            <div class="col-xs-12 col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Product</div>

                    <table class="table table-hover">
                        <tr>
                            <th>Count</th>
                            <td>{{ $product_count }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Seller Order panel --}}
            <div class="col-xs-12 col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Seller Order</div>

                    <table class="table table-hover">
                        <tr>
                            <th>Count</th>
                            <td>{{ $seller_order_count }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
