@extends('products.main',
['title' => $product->code])

@section('content')
    <form action="{{route('products.update',['productCode' => $product->code,])}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  value="{{$product->code}}">
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{$product->name}}">
        </label><br>
        <label >
            <b>Price</b>
            <input type="number" name="price" value="{{$product->price}}">
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" >{{$product->description}}</textarea>
        </label><br>
        <button type="submit">Update</button>
    </form>
@endsection