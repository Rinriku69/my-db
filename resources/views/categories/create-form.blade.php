@extends('categories.main',
['title' => "Create Product"])

@section('content')
    <form action="{{route('categories.create')}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  required>
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  required>
        </label><br>
        <label>
            <b>Description</b>
            <textarea name="description" cols="30" rows="10" required></textarea>
        </label><br>
        <button type="submit">Create</button>
    </form>
@endsection