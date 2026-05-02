<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/layout/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/common.css') }}">
    @yield('css')
</head>

<body>
    @include('components.header')

    <main>
        @yield('content')
    </main>
</body>

</html>
