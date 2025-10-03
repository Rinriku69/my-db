@extends('products.main', [
    'title' => $product->name,
])

@section('header')
    <nav>
        <form action="{{ route('products.delete', [
            'productCode' => $product->code,
        ]) }}" method="post"
            id="app-form-delete">
            @csrf
        </form>
        <ul>

            <li>
                <a href="{{ session()->get('bookmarks.products.view', route('products.list')) }}">&lt; Back</a>
            </li>

            <li>
                <a
                    href="{{ route('products.view-shops', [
                        'productCode' => $product->code,
                    ]) }}">View
                    Shop</a>
            </li>
            @can('update', $product)
                
            
            <li>
                <a
                    href="{{ route('products.update-form', [
                        'productCode' => $product->code,
                    ]) }}">Update</a>
            </li>
            @endcan
            @can('delete', $product)
            <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
            @endcan
        </ul>
    </nav>
@endsection

@section('content')
    @php
        session()->put('bookmarks.products.view-shops', url()->full());
    @endphp
    <dl>
        <dt>Code</dt>
        <dd>{{ $product->code }}</dd>
        <dt>Name</dt>
        <dd>{{ $product->name }}</dd>
        <dt>Category</dt>
        <dd>{{ $product->category->name }}</dd>
        <dt>Price</dt>
        <dd>{{ number_format((float) $product->price, 2) }}</dd>
    </dl>

    <pre>{{ $product->description }}</pre>
@endsection
