@extends('shops.main',
['title' => $category->code])

@section('content')
    <form action="{{route('categories.update',['categoryCode' => $category->code,])}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  value="{{$category->code}}">
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{$category->name}}">
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" >{{$category->description}}</textarea>
        </label><br>
        <button type="submit">Update</button>
    </form>
@endsection