@extends('categories.main',[
    'title' => "List"
])

@section('header')

    <nav>
      
      <search>
      <form action="{{ route('categories.list') }}" method="get">
        <div class="form">
        <label for="app-inp-search-term" >Search</label>
        <input  type="text" id="app-inp-search-term"
          name="term" value="{{ $criteria['term'] }}" /><br>
        <label>
        </div>
        <div class="button">
                <button type="submit">Search</button>
            <a href="{{ route('categories.list') }}">
                <button type="button">X</button>
            </a>
        </div>
      </form>
</search>
@can('create', \App\Models\Category::class)
    

<li class="app-cmp-links"><a href="{{route('categories.create-form')}}">New Category</a></li>
     @endcan 
{{$categories->withQueryString()->links()}}
    </nav>
@endsection

@section('content')
<table class="app-cmp-data-list">
  <thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>No. of Products</th>
    </tr>
  </thead>
  <tbody>
    @php
        session()->put('bookmarks.categories.create-form',url()->full());
        session()->put('bookmarks.categories.view',url()->full());
    @endphp
    @foreach ($categories as $category)
    <tr>
        <td>
        <a href="{{route('categories.view',[
        'categoryCode'=> $category->code],)}}">
        {{$category->code}}
        </a></td>
        <td>{{$category->name}}</td>
        <td>{{$category->products_count}}</td>
    </tr>
        
    @endforeach
  </tbody>
</table>
    
@endsection