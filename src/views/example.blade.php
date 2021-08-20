<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mẫu thay đổi ngôn ngữ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 50px;
            width: 800px;
            font-size: 20px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    @if ($errors->any())
        @foreach($errors as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    Mã ngôn ngữ hiện tại: <b>{{ app()->getLocale() }}</b>
    <br>
    @if (app()->getLocale()=='en')
        <a href="{{ route('localization::changeLocale','vi') }}">Thay đổi => vi</a>
    @else
        <a href="{{ route('localization::changeLocale','en') }}">Thay đổi => en</a>
    @endif
</div>
</body>
</html>