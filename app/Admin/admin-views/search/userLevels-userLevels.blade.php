<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">筛选</h4>
            </div>
            <form action="{{ route('admin::userLevels.index') }}" method="get" pjax-container>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group">
                            <div class="form-group">
                                <label>等级</label>
                                <input type="text" class="form-control" placeholder="等级" name="level" value="{{ request('level') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>等级名称</label>
                                <input type="text" class="form-control" placeholder="等级名称" name="name" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>创建时间</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="start" placeholder="开始时间" name="start" value="{{ request('start') }}">
                                    <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
                                    <input type="text" class="form-control" id="end" placeholder="结束时间" name="end" value="{{ request('end') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary submit">提交</button>
                    <button type="reset" class="btn btn-warning pull-left">撤销</button>
                </div>
            </form>
        </div>
    </div>
</div>