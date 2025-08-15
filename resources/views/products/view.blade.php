@extends('products.main',[
    'title' => $product->name,
])

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