@extends('products.main', ['title' => 'List'])
@section('header')
    <nav>

        <search>
            <form action="{{ route('products.list') }}" method="get">
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
                    <a href="{{ route('products.list') }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
        @php
            session()->put('bookmarks.products.create-form', url()->full());
        @endphp
        @can('create', \App\Models\Product::class)
        <li class="app-cmp-links"><a href="{{ route('products.create-form') }}">Create Product</a></li>
        @endcan
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
            @php
                session()->put('bookmarks.products.view', url()->full());
                session()->put('bookmarks.categories.view',url()->full());
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a
                            href="{{ route('products.view', [
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
