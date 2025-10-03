<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <header id="app-cmp-main-header">
        <nav>
            <ul class="app-cmp-links">
                <li><a href="{{ route('products.list') }}">Product List</a></li>
                <li><a href="{{ route('shops.list') }}">Shops List</a></li>
                <li><a href="{{ route('categories.list') }}">Categories</a></li>
                @can('create', \App\Models\User::class)
                 <li><a href="{{ route('users.list') }}">User</a></li>
                @endcan
                

            </ul>
        </nav>
        <nav class="app-cmp-user-panel">

            @auth

                <form action="{{ route('logout') }}" method="post">

                    @csrf
                    <a href="{{ route('users.selves.view') }}">
                        <span>{{ \Auth::user()->name }}</span></a>

                    <button type="submit">Logout</button>

                </form>

            @endauth

        </nav>
    </header>

    <main id="app-cmp-main-content">
        <header>
            <div class="notification">
                @session('status')
                    <div role="status">
                        {{ $value }}
                    </div>
                @endsession
            </div>
            <h1><span @class($titleClasses ?? [])>{{ $title }}</span></h1>
            @yield('header')


        </header>

        @yield('content')
        @php
            if (!Route::is('users.selves.*')) {
                session()->put('bookmarks.users.selves.view', url()->full());
            }
        @endphp
    </main>




    <footer id="app-cmp-main-footer">
        Created by Sirithep Pukim, Student ID: 662110103
    </footer>

</body>

</html>
