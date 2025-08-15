@extends('shops.main',[
    'title' => $shop->name,
])

@section('content')
    <dl>
        <dt>Code ::</dt>
        <dd>{{$shop->code}}</dd><br>
        <dt>Name ::</dt>
        <dd>{{$shop->name}}</dd><br>
        <dt>Owner ::</dt>
        <dd>{{$shop->owner}}</dd><br>
        <dt>Location ::</dt>
        <dd>{{$shop->latitude}} {{$shop->longitude}}</dd>
        <dt>Address ::</dt>
        <dd>{{$shop->address}}</dd><br>
        
    </dl>


@endsection