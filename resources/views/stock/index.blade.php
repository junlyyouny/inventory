@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @include('partials.errors')
                @include('partials.success')

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
                            <h1 class="page-header">查询库存</h1>
                            <form class="form-inline sale_from" role="form" method="post">
                                <div class="form-group">
                                    <label class="sr-only" for="stocksId">商品编码</label>
                                    <input type="text" class="form-control" id="stocksId" name="goods_num" placeholder="商品编码" value="{{ $goods_num or '' }}"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">-</div>
                                        <input class="form-control" type="text" id="barcode" name="bar_code" placeholder="条形码" value="{{ $bar_code or '' }}"></div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-primary">查询</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
                    <h2 class="page-header">待出库列表</h2>
                    <table id="stocks-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>库存编号</th>
                                <th>商品编码</th>
                                <th>条形码</th>
                                <th>数量</th>
                                <th data-sortable="false">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->id }}</td>
                                <td>{{ $stock->goods_num }}</td>
                                <td>{{ $stock->bar_code }}</td>
                                <td>{{ $stock->amount }}</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger do_del" data-toggle="modal" data-target="#modal-delete" data-key="{{ $stock->id }}">
                                        <i class="fa fa-times-circle"></i> 删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@stop

@include('partials.confirm')

@section('scripts')
<script>
    $(function() {
        $("#stocks-table").DataTable({
            order: [[0, "desc"]],
            "language": {
                "url": "/assets/zh_CN/dataTable.txt"
            }
        });

        $('.do_del').click(function(){
            var key = $(this).attr('data-key');
            $('#del_from').attr('action', '/stocks/delete/' + key);
        });
    });
</script>
@stop