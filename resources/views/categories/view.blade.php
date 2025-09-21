@extends('categories.main', [
    'title' => $category->name,
])

@section('header')
    <nav>
        <form action="{{ route('categories.delete', [
            'categoryCode' => $category->code,
        ]) }}" method="post" id="app-form-delete">
            @csrf
        </form>
        <ul>
            <li>
                <a href="{{ route('categories.view-products', [
                    'categoryCode' => $category->code,
                ]) }}">View Products</a>
            </li>
            <li>
                <a href="{{ route('categories.update-form', [
                    'categoryCode' => $category->code,
                ]) }}">Update</a>
            </li>
            <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <dl>
        <dt>Code ::</dt>
        <dd>{{ $category->code }}</dd><br>
        <dt>Name ::</dt>
        <dd>{{ $category->name }}</dd><br>
        <dd>{!!nl2br($category->description) !!}</dd><br>
       

    </dl>
@endsection
