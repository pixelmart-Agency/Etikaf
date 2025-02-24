<!DOCTYPE html>
<html lang="ar" dir="rtl">


<!-- login23:11-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ assetUrl('img/favicon-2.ico') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css_v2/bootstrap.rtl@5.3.3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css_v2/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css_v2/mahmoud_custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css_v2/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetUrl('css_v2/responsive.css') }}">


    <style>
        .login-form-errors {
            color: #a24b4b;
            font-size: 14px;
            font-weight: 310;
        }
    </style>
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
</head>

@yield('content')
@include('layouts.flash_message')
<script src="{{ assetUrl('js_v2/custom.js') }}"></script>
@yield('scripts')
</body>

</html>
