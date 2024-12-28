<!DOCTYPE html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body, body * {
                font-family: Vazirmatn, Arial, sans-serif;
            }
        </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
