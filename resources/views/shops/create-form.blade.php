@extends('products.main',
['title' => "Create Product"])

@section('content')
    <form action="{{route('shops.create')}}" method="POST">
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
            <b>Owner</b>
            <input type="text" name="owner" required>
        </label><br>
        <label >
            <b>Latitude</b>
            <input type="text" name="latitude" required>
        </label><br>
        <label >
            <b>Longitude</b>
            <input type="text" name="longitude" required>
        </label><br>
        <label>
            <b>Address</b>
            <textarea name="description" cols="30" rows="10" required></textarea>
        </label><br>
        <button type="submit">Create</button>
    </form>
@endsection