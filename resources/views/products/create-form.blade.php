@extends('products.main',
['title' => "Create Product"])

@section('content')
    <form action="{{route('products.create')}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  required>
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  required>
        </label><br>
        <label >
            <b>Category</b>
        <select name="category_id" id="">
            <option value="" selected>--Please selcet--</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}">
            [{{$category->code}}] {{$category->name}}</option>
            @endforeach
        </select></label><br>
        <label >
            <b>Price</b>
            <input type="number" name="price" required>
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" required></textarea>
        </label><br>
        <button type="submit">Create</button>
    </form>
@endsection