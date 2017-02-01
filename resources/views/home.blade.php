<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('stock.description') }}">
    <meta name="author" content="{{ config('stock.author') }}">
    <link rel="icon" href="/favicon.ico">
    <title>{{ config('stock.title', 'Laravel') }}</title>
    <!-- Custom styles for this template -->
    <link href="/css/home.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">臻益家</h3>
                        <ul class="nav masthead-nav">
                            <li>
                                <a href="/stocks/storage">入库</a>
                            </li>
                            <li>
                                <a href="/sales/delivering">出库</a>
                            </li>
                            <li>
                                <a href="/stocks">库存</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading">臻益家</h1>
                    <p class="lead">库存管理系统</p>
                    <p class="lead">
                        <a href="/stocks" class="btn btn-lg btn-primary">进入</a>
                    </p>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>
                            The template based
                            <a href="http://www.bootcss.com/" target="_blank">Bootstrap</a>
                            , Copyright
                            <a href="javascript:;">&copy; {{ config('stock.author') }}</a>
                            .
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</body>
</html>