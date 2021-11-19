<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/img/resize/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/img/resize/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/img/resize/favicon-16x16.png') }}">
        <link rel="shortcut icon" href="{{ asset('storage/img/resize/favicon.ico') }}" type="image/x-icon">
        <title>ProjekatA</title>
    </head>

    <body class="resize">
        <div class="w-full h-full flex justify-center items-center">
            <div class="flex flex-col items-center">
                <div class="typewriter text-red-800 text-8xl py-4">
                    <h1>Miljan Jovic is gay!</h1>
                </div>

                <h2
                        id="hidden"
                        class="mt-4 text-2xl text-white hidden"
                >
                    Diso nemoj se smejes i ti si.
                </h2>

                <div>
                    <button
                            id="button"
                            class="text-white text-2xl mt-8 p-6 bg-red-800 rounded-xl hover:bg-red-700 transition-all"
                    >
                        CLICK ME
                    </button>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}" rel="script"></script>
    </body>
</html>
