@extends('products.main',
['title' => "Create Product"])

@section('content')
    <form action="{{route('products.create')}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code" value="{{old('code')}}" required>
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{old('name')}}"required>
        </label><br>
        <label >
            <b>Category</b>
        <select name="category_code" id="">
            <option value="" >--Please selcet--</option>
            @foreach ($categories as $category)
                <option value="{{$category->code}}" 
                    @selected($category->code === old('category_code'))>
            [{{$category->code}}] {{$category->name}}</option>
            @endforeach
        </select></label><br>
        <label >
            <b>Price</b>
            <input type="number" name="price" value="{{old('price')}}"required>
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" required>{{old('description')}}</textarea>
        </label><br>
        <button type="submit">Create</button>
        <a href="{{session()->get('bookmarks.products.create-form',route('products.list'))}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection