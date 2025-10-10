@extends('layouts.main',
['title' => $user->name])

@section('content')
    <form action="{{route('users.selves.update')}}" method="POST">
        @csrf
        <label >
            <b>Email</b>
            <input type="email" name="email"  value="{{old('email',$user->email)}}" readonly >
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{old('name',$user->name)}}">
        </label><br>
        
        <label>
            <b>Role</b>
            @if ($user->email !== \Auth::user()->email)
            <select name="role" id="">
                    <option value="USER" @selected(old('role',$user->role) === 'USER')>
                     USER</option>
                    <option value="ADMIN" @selected(old('role',$user->role) === 'ADMIN')>
                     ADMIN</option>
            </select></label><br>
            @else
            <input type="text" name="role"  value="{{old('role',$user->role)}}" readonly ><br>
            @endif
        <label >
            <b>Password</b>
            <input type="text" name="password"  value="" placeholder="Leave blank to not update">
        </label><br>
        
        <button type="submit">Update</button>
        <a href="{{ route('users.selves.view')}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection