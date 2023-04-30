<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тестовое задание</title>
    @vite(['resources/js/main.js'])
</head>
<body class="bg-light">
    <div class="container-sm">

        @yield("content")

        <form action="{{ route('logout') }}" method="post" class="mt-3">
            @csrf
            <input type="submit" value="Выйти">
        </form>
    </div>


</body>
</html>
