<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <meta name="description" content="Birla Opus User Portal is a loyalty application for Painters, User & Institutional User." />
    <meta name="keywords" content="Loyalty Application, Birla Opus Paints" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="{!! asset('assets/media/logos/easternicon.webp') !!}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0px;
            line-height: 1.6;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        ol {
            list-style-type: none;
            padding-left: 0;
        }

        ol li {
            margin-left: 1.5em;
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 20px;
            }
        }

        .text-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media only screen and (max-width: 480px) {
            .small-font {
                font-size: 24px;
            }

            .large-font {
                font-size: 36px;
            }
        }

        @media only screen and (min-width: 320px) and (max-width: 425px) {
            .small-font {
                font-size: 20px;
            }

            .large-font {
                font-size: 33px;
            }
        }

        @media only screen and (max-width: 320px) {
            .small-font {
                font-size: 16px;
            }

            .large-font {
                font-size: 30px;
            }
        }
    </style>

    <!-- Scripts -->
    @livewireStyles

</head>

<body id="kt_body" class="bg-body">
    {{ $slot }}
    @livewireScripts
</body>
<!--end::Main-->

</html>
