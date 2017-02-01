@extends('layouts.admin')

@section('styles')
    <link href="/assets/pickadate/themes/default.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.date.css" rel="stylesheet">
    <!-- <link href="/assets/pickadate/themes/default.time.css" rel="stylesheet"> -->
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                @include('partials.errors')
                @include('partials.success')

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
                            <h1 class="page-header">查询流水</h1>
                            <form class="form-inline sale_from" role="form" method="post">
                                <div class="form-group">
                                    <label class="sr-only" for="startTime">开始时间</label>
                                    <input type="text" class="form-control seachTime" id="startTime" name="startTime" placeholder="开始时间" value="{{ $startTime or '' }}" />
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">-</div>
                                        <input class="form-control seachTime" type="text" id="endTime" name="endTime" placeholder="结束时间" value="{{ $endTime or '' }}" />
                                    </div>
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
                    <h2 class="page-header">流水列表</h2>
                    <table id="stocks-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>流水号</th>
                                <th>商品编码</th>
                                <th>条形码</th>
                                <th>数量</th>
                                <th>出库时间</th>
                                <th data-sortable="false">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->goods_num }}</td>
                                <td>{{ $sale->bar_code }}</td>
                                <td>{{ $sale->amount }}</td>
                                <td>{{ $sale->created_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger do_del" data-toggle="modal" data-target="#modal-delete" data-key="{{ $sale->id }}">
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
<script src="/assets/pickadate/picker.js"></script>
<script src="/assets/pickadate/picker.date.js"></script>
<script src="/assets/pickadate/zh_CN.js"></script>
<!-- <script src="/assets/pickadate/picker.time.js"></script> -->
<script>
    $(function() {
        $("#stocks-table").DataTable({
            order: [[0, "desc"]],
            "language": {
                "url": "/assets/zh_CN/dataTable.txt"
            }
        });

        $(".seachTime").pickadate({
            format: "yyyy-mm-dd"
        });

        $('.do_del').click(function(){
            var key = $(this).attr('data-key');
            $('#del_from').attr('action', '/sales/delete/' + key);
        });
    });
</script>
@stop