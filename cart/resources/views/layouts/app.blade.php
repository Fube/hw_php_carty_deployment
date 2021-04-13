<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Carty</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
        <script>
            const csrf = document.head.querySelector('meta[name="csrf-token"]');
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
        </script>
    </head>
    <body class="bg-gray-200">
        <nav class="p-6 bg-white flex justify-between mb-6">
            @auth
                <ul class="flex items-center">
                    <li class="px-2"><a href="/">{{ auth()->user()->name }}</a></li>
                    <li class="px-2">
                        <form action="{{ route('search') }}" method="post">
                            @csrf
                            <input type="text" name="search" id="search" placeholder="Search item" class="border-b border-black">
                        </form>
                    </li>
                </ul>

                <ul class="flex items-center">
                    <li class="px-2"><a href="{{ route('cart') }}">Cart</a></li>
                    @if (auth()->user()->type == 'admin')
                        <li class="px-2"><a href="{{ route('admin') }}">Admin Dashboard</a></li>
                    @endif
                    <li class="px-2">
                        <form action="{{ route('logout') }}" method="post" class="inline">
                            @csrf
                            <button type="submit" class="inline">Logout</button>
                        </form>
                    </li>
                </ul>
            @endauth

            @guest
                <ul class="flex items-center">
                    <li><a href="" class="p-3">Guest</a></li>
                </ul>
                <ul class="flex items-center">
                    <li><a href="{{ route('login') }}" class="p-3">Login</a></li>
                    <li><a href="{{ route('register') }}" class="p-3">Register</a></li>
                </ul>
            @endguest

        </nav>
        @yield('content')
    </body>
</html>