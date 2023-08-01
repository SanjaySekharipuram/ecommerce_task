<h2>Cart Items</h2>

@if (count($cart) > 0)
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>${{ $item['price'] }}</td>
                    <td>${{ $item['price'] * $item['quantity'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total: ${{ array_sum(array_map(function ($item) { return $item['price'] * $item['quantity']; }, $cart)) }}</p>
@else
    <p>Your cart is empty.</p>
@endif
