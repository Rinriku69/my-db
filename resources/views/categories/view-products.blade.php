@extends('categories.main', ['title' => $categoryCode.' Product'])
@section('header')
    <nav>

        <search>
            <form action="{{ route('categories.view-products', ['categoryCode' => $categoryCode]) }}" method="get">
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
                    <a href="{{ route('categories.view-products', ['categoryCode' => $categoryCode]) }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
        <li class="app-cmp-links"><a href="{{ route('categories.add-product-form', 
        ['categoryCode' => $categoryCode]) }}">Add product</a></li>
        <li class="app-cmp-links"><a href="{{ route('categories.view', ['categoryCode' => $categoryCode]) }}">Back</a></li>
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

            </tr>
        </thead>
        <tbody>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
