<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('jquery.js') }}"></script>
</head>

<body>
    <div class="grid h-screen justify-center items-center">
        <div class="card lg:card-side bg-base-200 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Login</h2>
                <form action="/login" method="POST" class="mt-1 grid gap-5">
                    @csrf
                    <div class="grid">
                        <input name="email" type="email" placeholder="Gmail" class="input input-bordered w-96" />
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="grid">
                        <input name="password" type="password" placeholder="password" class="input input-bordered w-96" />
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="card-actions justify-end">
                        <button type="login" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
