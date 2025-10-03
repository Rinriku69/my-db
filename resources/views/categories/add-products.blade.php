@extends('categories.main', ['title' => $category->code.' Product'])
@section('header')
    <nav>

        <search>
            <form action="{{ route('categories.add-product-form', ['categoryCode' => $category->code]) }}" method="get">
                <div class="form">
                    <label for="app-inp-search-term">Search</label>
                    <input type="text" id="app-inp-search-term" name="term" value="{{ $criteria['term'] }}" /><br>
                    <label>
                        Min Price
                        <input type="number" name="minPrice" value="{{ $criteria['minPrice'] }}" step="any" />
                    </label><br />
                    <label>
                        Max Price
                        <input type="number" name="maxPrice" value="{{ $criteria['maxPrice'] }}" step="any" />
                    </label><br />
                </div>
                <div class="button">
                    <button type="submit">Search</button>
                    <a href="{{ route('categories.view-products', ['categoryCode' => $category->code]) }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
    </nav>
    <nav>
        <form action="{{route('categories.add-product-form', 
        ['categoryCode' => $category->code])}}" id="add-product" method="POST">@csrf</form>
        <li class="app-cmp-links">
            <a href="{{ session('bookmarks.categories.add-products-form',
            route('categories.view-products', ['categoryCode' => $category->code])) }}">Back</a></li>
        {{ $products->withQueryString()->links() }}
    </nav>
@endsection


@section('content')
    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>No. of Shops</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.products.view', url()->full());
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.view', [
                            'productCode' => $product->code,
                        ]) }}">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->shops_count }}</td>
                    <td>
                        <button type="submit" form="add-product" name="product" value="{{$product->code}}">Add</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
