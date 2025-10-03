@extends('shops.main', [
    'title' => 'List',
])

@section('header')
    <nav>

        <search>
            <form action="{{ route('shops.list') }}" method="get">
                <div class="form">
                    <label for="app-inp-search-term">Search</label>
                    <input type="text" id="app-inp-search-term" name="term" value="{{ $criteria['term'] }}" /><br>
                    <label>
                </div>
                <div class="button">
                    <button type="submit">Search</button>
                    <a href="{{ route('shops.list') }}">
                        <button type="button">X</button>
                    </a>
                </div>
            </form>
        </search>
        @php
            session()->put('bookmarks.shops.create-form', url()->full());
            session()->put('bookmarks.shops.view', url()->full());
        @endphp
        @can('create', \App\Models\Shop::class)
        <li class="app-cmp-links"><a href="{{ route('shops.create-form') }}">Create Shop</a></li>
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
                <th>No. of Products</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shops as $shop)
                <tr>
                    <td>
                        <a href="{{ route('shops.view', [
                            'shopCode' => $shop->code,
                        ]) }}">
                            {{ $shop->code }}
                        </a>
                    </td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->owner }}</td>
                    <td>{{ $shop->products_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
