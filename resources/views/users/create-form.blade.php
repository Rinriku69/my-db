@extends('layouts.main',
['title' => "New User"])

@section('content')
    <form action="{{route('users.create')}}" method="POST">
        @csrf
        <label >
            <b>Name</b>
            <input type="text" name="name" value="{{old('name')}}" required>
        </label><br>
        <label>
            <b>Role</b>
            <select name="role" required>
                <option value="">--Please Select Role--</option>
                <option value="USER" @selected(old('role') == "USER")>USER</option>
                <option value="ADMIN" @selected(old('role') == "ADMIN")>ADMIN</option>
            </select>
        </label><br>
        <label >
            <b>Email</b>
        <input type="email" name="email" value="{{old('email')}}" required>
        </label>
        <br>
        
        <label>
            <b>Password</b>
            <input type="text" name="password" value="{{old('')}}" required>
        </label><br>
        
        <button type="submit">Create</button>
        <a href="{{route('users.list')}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection