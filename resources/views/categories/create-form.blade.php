@extends('categories.main',
['title' => "Create Product"])

@section('content')
    <form action="{{route('categories.create')}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code" value="{{old('code')}}" required>
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name" value="{{old('name')}}" required>
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" required>{{old('description')}}</textarea>
        </label><br>
        <button type="submit">Create</button>
        <a href="{{session()->get('bookmarks.categories.create-form',
        route('categories.list'))}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection