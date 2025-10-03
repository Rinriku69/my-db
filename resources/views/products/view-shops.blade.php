@extends('products.main', [
    'title' => $product->code . ' Shops',
])

@section('header')
    <nav>

        <search>
            <form action="{{ route('products.view-shops', ['productCode' => $product->code]) }}" method="get">
                <div class="form">
                    <label for="app-inp-search-term">Search</label>
                    <input type="text" id="app-inp-search-term" name="term" value="{{ $criteria['term'] }}" /><br>
                    <label>
                </div>
                <div class="button">
                    <button type="submit">Search</button>
                    <a href="{{ route('products.view-shops', ['productCode' => $product->code]) }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
    </nav>
    <nav>
        <form action="{{ route('products.remove-shop', [
            'productCode' => $product->code,
        ]) }}"
            method="post" id="remove-shop">@csrf</form>
        <li class="app-cmp-links"><a
                href="{{ session('bookmarks.products.view-shops', 
                route('products.view', 
                ['productCode' => $product->code])) }}">Back</a>
        </li>
        @can('create', $product)
        <li class="app-cmp-links"><a
                href="{{ route('products.add-shops-form', [
                    'productCode' => $product->code,
                ]) }}">Add
                shops</a></li> 
        @endcan
        {{ $shops->withQueryString()->links() }}
    </nav>
@endsection

@section('content')
    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
                <th>No.of Products</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.products.add-shops-form', url()->full());
                session()->put('bookmarks.shops.view', url()->full());
            @endphp
            @foreach ($shops as $shop)
                <tr>
                    <td>
                        <a
                            href="{{ route('shops.view', [
                                'shopCode' => $shop->code,
                            ]) }}">
                            {{ $shop->code }}
                        </a>
                    </td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->owner }}</td>
                    <td>{{ $shop->products_count }}</td>
                    @can('delete', $product)
                    <td>
                        <button type="submit" form="remove-shop" name="shop"
                            value="{{ $shop->code }}">Remove</button>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
