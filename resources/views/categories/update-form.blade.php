@extends('shops.main',
['title' => $category->code])

@section('content')
    <form action="{{route('categories.update',['categoryCode' => $category->code,])}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  value="{{old('code',$category->code)}}">
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{old('name',$category->name)}}">
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" >{{old('description',$category->description)}}</textarea>
        </label><br>
        <button type="submit">Update</button>
        <a href="{{ route('categories.view',
        ['categoryCode' => $category->code])}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection