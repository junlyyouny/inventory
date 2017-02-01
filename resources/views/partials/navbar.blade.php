{{-- Navigation --}}
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
              data-target="#navbar-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ config('stock.description') }}</a>
        </div>
        {{-- Collect the nav links, forms, and other content for toggling --}}
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/">首页</a>
                </li>
                <li @if (Request::is('stocks/storage*')) class="active" @endif>
                    <a href="/stocks/storage">入库</a>
                </li>
                <li @if (Request::is('stocks')) class="active" @endif>
                    <a href="/stocks/">库存</a>
                </li>
                <li @if (Request::is('sales/delivering*')) class="active" @endif>
                    <a href="/sales/delivering">出库</a>
                </li>
                <li @if (Request::is('sales')) class="active" @endif>
                    <a href="/sales/">流水</a>
                </li>
            </ul>
        </div>
    </div>
</nav>