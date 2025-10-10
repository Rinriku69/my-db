@extends('shops.main',
['title' => $shop->code])

@section('content')
    <form action="{{route('shops.update',['shopCode' => $shop->code,])}}" method="POST">
        @csrf
        <label >
            <b>Code</b>
            <input type="text" name="code"  value="{{old('code',$shop->code)}}">
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{old('name',$shop->name)}}">
        </label><br>
        <label >
            <b>Owner</b>
            <input type="text" name="owner" value="{{old('owner',$shop->owner)}}">
        </label><br>
        <label >
            <b>Latitude</b>
            <input type="text" name="latitude" value="{{old('latitude',$shop->latitude)}}">
        </label><br>
        <label >
            <b>Longitude</b>
            <input type="text" name="longitude" value="{{old('longitude',$shop->longitude)}}">
        </label><br>
        <label>
            <b>Address</b>
            <textarea name="address" cols="30" rows="10" >{{old('address',$shop->address)}}</textarea>
        </label><br>
        <button type="submit">Update</button>
        <a href="{{route('shops.view',['shopCode'=>$shop->code])}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection