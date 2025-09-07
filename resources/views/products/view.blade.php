@extends('products.main',[
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
<a href="{{ route('products.update-form', [
'productCode' => $product->code,
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
        <dt>Code</dt>
        <dd>{{$product->code}}</dd>
        <dt>Name</dt>
        <dd>{{$product->name}}</dd>
        <dt>Price</dt>
        <dd>{{number_format((float)$product->price,2)}}</dd>
    </dl>

    <pre>{{$product->description}}</pre>
@endsection