<br>
<br>
<br>

<style>
    table {
        width: 100%;
        text-align: left;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
    }
</style>

<table>
    <tr>
        <th></th>
        <th scope="col">Users</th>
        <th scope="col">Books</th>
        <th scope="col">Products</th>
        <th scope="col">Buyer orders</th>
        <th scope="col">Seller orders</th>
    </tr>
    <tr>
        <th scope="row">Today</th>
        <td>{{ \App\User::signedUpAfter(\Carbon\Carbon::today())->count() }}</td>
        <td>{{ \App\Book::createdAfter(\Carbon\Carbon::today())->count() }}</td>
        <td>{{ \App\Product::createdAfter(\Carbon\Carbon::today())->count() }}</td>
        <td>{{ \App\SellerOrder::createdAfter(\Carbon\Carbon::today())->count() }}</td>
        <td>{{ \App\BuyerOrder::createdAfter(\Carbon\Carbon::today())->count() }}</td>
    </tr>
    <tr>
        <th scope="row">Last week</th>
        <td>{{ \App\User::signedUpAfter(\Carbon\Carbon::now()->subDays(7))->count() }}</td>
        <td>{{ \App\Book::createdAfter(\Carbon\Carbon::now()->subDays(7))->count() }}</td>
        <td>{{ \App\Product::createdAfter(\Carbon\Carbon::now()->subDays(7))->count() }}</td>
        <td>{{ \App\SellerOrder::createdAfter(\Carbon\Carbon::now()->subDays(7))->count() }}</td>
        <td>{{ \App\BuyerOrder::createdAfter(\Carbon\Carbon::now()->subDays(7))->count() }}</td>
    </tr>
    <tr>
        <th scope="row">Last month</th>
        <td>{{ \App\User::signedUpAfter(\Carbon\Carbon::now()->subMonth(1))->count() }}</td>
        <td>{{ \App\Book::createdAfter(\Carbon\Carbon::now()->subMonth(1))->count() }}</td>
        <td>{{ \App\Product::createdAfter(\Carbon\Carbon::now()->subMonth(1))->count() }}</td>
        <td>{{ \App\SellerOrder::createdAfter(\Carbon\Carbon::now()->subMonth(1))->count() }}</td>
        <td>{{ \App\BuyerOrder::createdAfter(\Carbon\Carbon::now()->subMonth(1))->count() }}</td>
    </tr>
    <tr>
        <th scope="row">Total</th>
        <td>{{ \App\User::all()->count() }}</td>
        <td>{{ \App\Book::all()->count() }}</td>
        <td>{{ \App\Product::all()->count() }}</td>
        <td>{{ \App\SellerOrder::all()->count() }}</td>
        <td>{{ \App\BuyerOrder::all()->count() }}</td>
    </tr>
</table>