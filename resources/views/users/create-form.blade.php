@extends('layouts.main',
['title' => "New User"])

@section('content')
    <form action="{{route('users.create')}}" method="POST">
        @csrf
        <label >
            <b>Name</b>
            <input type="text" name="name"  required>
        </label><br>
        <label>
            <b>Role</b>
            <select name="role">
                <option value="USER">USER</option>
                <option value="ADMIN">ADMIN</option>
            </select>
        </label><br>
        <label >
            <b>Email</b>
        <input type="email" name="email"  required>
        </label>
        <br>
        
        <label>
            <b>Password</b>
            <input type="text" name="password"  required>
        </label><br>
        
        <button type="submit">Create</button>
        <a href="{{route('users.list')}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection