{{-- 确认删除 --}}
<div class="modal fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">请确认</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    您确定要删除该记录吗?
                </p>
            </div>
            <div class="modal-footer">
                <form method="get" action="" id="del_from">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times-circle"></i> 删除
                    </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">
                        取消
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>