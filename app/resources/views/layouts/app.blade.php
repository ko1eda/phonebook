<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Font Awesome from cdn to save time -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    @include('partials.navbar')

    {{-- add extra section for spacing --}}
    <div class="section"></div>

    <main class="section">
      <div class="container">
        @yield('content')
      </div>
    </main>

    <flash-message></flash-message>
  </div>

  <script src="{{ mix('js/app.js') }}" ></script>
</body>
</html>
