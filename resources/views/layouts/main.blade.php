<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title >{{$title}}</title>
    <link rel="stylesheet" type="text/css"
href="{{ asset('css/common.css') }}" />
</head>
<body>
    <header id="app-cmp-main-header">
      <nav>
      <ul class="app-cmp-links">
       <li><a href="{{route('products.list')}}">Product List</a></li>
       <li><a href="{{route('shops.list')}}">Shops List</a></li>
       
       
      </ul>   
    </nav>
    </header>

    <main id="app-cmp-main-content">
        <header>
            <h1><span @class($titleClasses ?? [])>{{$title}}</span></h1>
            @yield('header')
        </header>
    
        @yield('content')
        
    </main>
    

    

    <footer id="app-cmp-main-footer">
      Created by Sirithep Pukim, Student ID: 662110103
    </footer>

</body>
</html>