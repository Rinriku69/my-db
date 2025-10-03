@extends('shops.main', [
    'title' => $shop->name,
])

@section('header')
    <nav>
        <form action="{{ route('shops.delete', [
            'shopCode' => $shop->code,
        ]) }}" method="post" id="app-form-delete">
            @csrf
        </form>
        <ul>
            <li>
                <a href="{{ session()->get('bookmarks.shops.view', route('shops.list')) }}">&lt; Back</a>
            </li>
            <li>
                <a href="{{ route('shops.view-products', [
                    'shopCode' => $shop->code,
                ]) }}">View Products</a>
            </li>
            @can('update', $shop)
               <li>
                <a href="{{ route('shops.update-form', [
                    'shopCode' => $shop->code,
                ]) }}">Update</a>
            </li> 
            @endcan
            @can('delte', $shop)
               <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li> 
            @endcan
            
        </ul>
    </nav>
@endsection

@section('content')
@php
    session()->put('bookmarks.shops.view-products', url()->full());
@endphp
    <dl>
        <dt>Code ::</dt>
        <dd>{{ $shop->code }}</dd><br>
        <dt>Name ::</dt>
        <dd>{{ $shop->name }}</dd><br>
        <dt>Owner ::</dt>
        <dd>{{ $shop->owner }}</dd><br>
        <dt>Location ::</dt>
        <dd>{{ $shop->latitude }} {{ $shop->longitude }}</dd>
        <dt>Address ::</dt>
        <dd>{!! nl2br($shop->address) !!}</dd><br>

    </dl>
@endsection
