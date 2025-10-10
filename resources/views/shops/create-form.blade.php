@extends('layouts.main',
['title' => "Create Shop"])

@section('content')
    <form action="{{route('shops.create')}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  value="{{old('code')}}" required>
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name" value="{{old('name')}}" required>
        </label><br>
        <label >
            <b>Owner</b>
            <input type="text" name="owner" value="{{old('owner')}}" required>
        </label><br>
        <label >
            <b>Latitude</b>
            <input type="text" name="latitude" value="{{old('latitude')}}" required>
        </label><br>
        <label >
            <b>Longitude</b>
            <input type="text" name="longitude" value="{{old('longitude')}}" required>
        </label><br>
        <label>
            <b>Address</b>
            <textarea name="address" cols="30" rows="10" required>{{old('address')}}</textarea>
        </label><br>
        <button type="submit">Create</button>
        <a href="{{session()->get('bookmarks.shops.create-form',route('shops.list'))}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection