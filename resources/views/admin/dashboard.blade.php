<br>
<br>
<br>

<h2>Statistics</h2>

<table style="width: 100%; text-align: left;">
    <tr>
        <th></th>
        <th scope="col">Users</th>
        <th scope="col">Books</th>
        <th scope="col">Products</th>
    </tr>
    <tr>
        <th scope="row">Today</th>
        <td>{{ \App\User::createdAfter(\Carbon\Carbon::today()) }}</td>
        <td>1</td>
        <td>1</td>
    </tr>
    <tr>
        <th scope="row">Last week</th>
        <td>2</td>
        <td>2</td>
        <td>2</td>
    </tr>
    <tr>
        <th scope="row">Total</th>
        <td>{{ \App\User::all()->count() }}</td>
        <td>{{ \App\Book::all()->count() }}</td>
        <td>{{ \App\Product::all()->count() }}</td>
    </tr>
</table>