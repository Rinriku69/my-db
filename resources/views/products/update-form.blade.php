@extends('products.main', ['title' => $product->code])

@section('content')
    <form action="{{ route('products.update', ['productCode' => $product->code]) }}" method="POST">
        @csrf
        <label>
            <b>Code</b>
            <input type="text" name="code" value="{{old('code',$product->code)  }}">
        </label><br>
        <label>
            <b>Name</b>
            <input type="text" name="name" value="{{ old('name',$product->name) }}">
        </label><br>
        <label>
            <b>Category</b>
            <select name="category_code" id="">
                @foreach ($categories as $category)
                    <option value="{{ $category->code }}" @selected($category->code === old('category_code',$product->category->code))>
                        [{{ $category->code }}] {{ $category->name }}</option>
                @endforeach
            </select></label><br>
        <label>
            <b>Price</b>
            <input type="number" name="price" value="{{ old('price',$product->price) }}">
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10">{{old('description',$product->description) }}</textarea>
        </label><br>
        <button type="submit">Update</button>
        <a href="{{ route('products.view', [
            'productCode' => $product->code,
        ]) }}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection
