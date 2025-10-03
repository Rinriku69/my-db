@extends('products.main', [
    'title' => $product->code . ' Add Shops',
])

@section('header')
    <nav>

        <search>
            <form action="{{ route('products.add-shops-form', ['productCode' => $product->code]) }}" method="get">
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
        <form action="{{ route('products.add-shops', [
            'productCode' => $product->code,
        ]) }}" method="POST"
            id="add-shops">
             @csrf
        </form>
       
        <li class="app-cmp-links"><a
                href="{{ session('bookmarks.products.add-shops-form', 
                route('products.view-shops', 
                ['productCode' => $product->code])) }}">Back</a>
        </li>
        {{ $shops->withQueryString()->links() }}
    </nav>
@endsection

@section('content')
    @csrf
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
                    <td>
                        <button type="submit" form="add-shops" name="shop" value="{{$shop->code}}">Add</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
