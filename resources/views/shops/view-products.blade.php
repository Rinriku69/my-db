@extends('shops.main', ['title' => $shop->code.' Product'])
@section('header')
    <nav>

        <search>
            <form action="{{ route('shops.view-products', ['shopCode' => $shop->code]) }}" method="get">
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
                    <a href="{{ route('shops.view-products', ['shopCode' => $shop->code]) }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
    </nav>
    <nav>
        <form action="{{route('shops.remove-product',[
        'shopCode' => $shop->code])}}" id="remove-product"
        method="POST">@csrf</form>
        <li class="app-cmp-links"><a href="{{ route('shops.add-product-form', ['shopCode' => $shop->code]) }}">Add product</a></li>
        <li class="app-cmp-links">
            <a href="{{ session('bookmarks.shops.view-products'
            ,route('shops.view', ['shopCode' => $shop->code])) }}">Back</a></li>
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
                session()->put('bookmarks.shops.add-products-form', url()->full());
                session()->put('bookmarks.products.view', url()->full());
                session()->put('bookmarks.categories.view',url()->full());
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
                    <td>
                        <a
                            href="{{ route('categories.view', [
                                'categoryCode' => $product->category->code,
                            ]) }}">
                            {{ $product->category->name }}
                        </a>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->shops_count }}</td>
                    <td>
                        <button type="submit"  form="remove-product" name="product" value="{{$product->code}}">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
