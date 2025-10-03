<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
</head>
<title>Login</title>
</head>

<body>
    <form action="{{ route('authenticate') }}" method="post">
        @csrf
        <div class="form-group">
        <label>
            E-mail <input type="email" id="username" name="email" required />
        </label><br />
        </div>
        <div class="form-group">
        <label>
            Password <input type="password" id="password" name="password" required />
        </label><br />
        </div>
        <button type="submit" class="login-button">Login</button>
        <div class="app-cmp-notifications">
            @error('credentials')
                <div role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </form>
</body>

</html>
