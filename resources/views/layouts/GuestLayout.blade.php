<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Blog' }}</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('jquery.js') }}"></script>
</head>

<body>
    <x-sidebar>
        {{ $slot }}
    </x-sidebar>

    <div id="loading_screen"
        class="fixed top-0 left-0 w-screen h-screen bg-base-300 opacity-0 transition-opacity duration-300">
        <div class="flex items-center justify-center h-full">
            <span class="loading loading-spinner loading-lg"></span>
        </div>
    </div>
    <script>
        hideLoadingScreen()

        function showLoadingScreen() {
            $("#loading_screen").removeClass("opacity-0");
        }

        function hideLoadingScreen() {
            $("#loading_screen").addClass("hidden");
        }
    </script>
</body>

</html>
