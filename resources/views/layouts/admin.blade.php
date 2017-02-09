<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('stock.description') }}</title>

        <link href="/assets/css/admin.css" rel="stylesheet">
        @yield('styles')

        <!--[if lt IE 9]>
            <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        @include('partials.navbar')

        <div style="margin: 60px 0 0;"></div>
        
        @yield('content')

        <script src="/assets/js/admin.js"></script>

        @yield('scripts')

    </body>
</html>