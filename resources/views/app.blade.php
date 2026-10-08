<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    
    <!-- Panggil CSS dan JS Vite bersamaan -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
  </head>
  <body class="bg-slate-900 text-slate-100 antialiased">
    @inertia
  </body>
</html>