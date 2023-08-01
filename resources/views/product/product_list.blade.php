<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach($products as $product)
    <h3>{{ $product->name }}</h3>
    <p>Price: ${{ $product->price }}</p>
    <form action="{{ route('cart.add') }}" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Add to Cart</button>
    </form>
@endforeach


<ul>
    <li>
        <a href="{{ route('cart.show') }}">
           Show cart items
        </a>
    </li>

</ul>

</body>
</html>