<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>


<body class="login-page-body">

   
    <div class="login-container">
        
        
        <form action="{{ route('authenticate') }}" method="post" class="login-form">
            @csrf

            <div class="form-header">
                <h1>Welcome Back</h1>
                <p>Please enter your details to sign in.</p>
            </div>

            <div class="form-group">
              
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>

            <button type="submit" class="login-button w-full">Login</button>
            
            <div class="app-cmp-notifications">
                @error('credentials')
                    <div role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </form>
    </div>

</body>
</html>
