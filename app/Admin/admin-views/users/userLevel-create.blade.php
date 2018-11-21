@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增会员等级</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::userLevels.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::userLevels.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">等级名称</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="name" name="name" value="" class="form-control" placeholder="输入 等级名称">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="level" class="col-sm-2 control-label">等级</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="level" name="level" value="0" style="padding-right:12px;" onkeyup='this.value=this.value.replace(/\D/gi,"")' class="form-control" placeholder="输入 等级">
                                    </div>
                                </div>
                                <label class="col-sm-6 control-label" style="color:red;border:0;text-align:left;">会员等级，越大等级越高</label>
                            </div>
                            <div class="form-group">
                                <label for="date_num" class="col-sm-2 control-label">满足天数</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="date_num" name="date_num" value="0" style="padding-right:12px;"  class="form-control" placeholder="输入 天数">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date_money" class="col-sm-2 control-label">每日消费金额</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="date_money" name="date_money" value="0" style="padding-right:12px;"  class="form-control" placeholder="输入 金额">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="brands" class="col-sm-2 control-label">分类集合</label>
                                <div class="col-sm-8">
                                    <select class="form-control brands" style="width: 100%;" name="brands[]" multiple="multiple" data-placeholder="输入 分类"  >
                                        @foreach($itemCategories as $brand)
                                            <option value="{{ $brand->id }}" >{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brands_money" class="col-sm-2 control-label">分类集合月消费金额</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="brands_money" name="brands_money" value="0" style="padding-right:12px;"  class="form-control" placeholder="输入 金融">
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="upgrade_way" class="col-sm-2 control-label">升级模式</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<lable class="radio-inline">--}}
                                            {{--<input type="radio"  name="upgrade_way" value="0" checked="checked" /> 手动升级--}}
                                        {{--</lable>--}}
                                        {{--<lable class="radio-inline">--}}
                                            {{--<input type="radio"  name="upgrade_way" value="1" /> 自动升级--}}
                                        {{--</lable>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="upgrade_condition" class="col-sm-2 control-label">升级说明</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <textarea name="upgrade_condition" id="upgrade_condition" rows="8" class="form-control" placeholder="升级说明"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">重置</button>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="submit" id="submit-btn" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('.form-history-back').on('click', function (event) {
                event.preventDefault();
                history.back(1);
            });
        });

        $('.brands').bootstrapDualListbox({
            "infoText": "text_total",
            "infoTextEmpty": "text_empty",
            "infoTextFiltered": "过滤",
            "filterTextClear": "清除",
            "filterPlaceHolder": "搜索"
        });

        $("#date_num").bootstrapNumber({
            'upClass': 'success',
            'downClass': 'primary',
            'center': true
        });

        $("#date_money").bootstrapNumber({
            'upClass': 'success',
            'downClass': 'primary',
            'center': true
        });

        $("#brands_money").bootstrapNumber({
            'upClass': 'success',
            'downClass': 'primary',
            'center': true
        });

        $("#post-form").bootstrapValidator({
            live: 'enable',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name:{
                    validators:{
                        notEmpty:{
                            message: '等级名称不能为空'
                        },
                        stringLength:{
                            max:32,
                            message: '等级名称长度必须在32个字符内'
                        },
                        remote: {
                            url: "{{ route('admin::userLevels.checkName') }}" ,
                            message: '该等级名称已存在',
                            delay: 200,
                            type: 'get'
                        },
                    }
                },
                level:{
                    validators:{
                        notEmpty:{
                            message: '等级不能为空'
                        },
                        remote: {
                            url: "{{ route('admin::userLevels.checkLevel') }}" ,
                            message: '该等级已存在',
                            delay: 200,
                            type: 'get'
                        },
                    }
                },
                upgrade_condition:{
                    validators:{
                        notEmpty:{
                            message: '升级说明不能为空'
                        },
                        stringLength:{
                            max:256,
                            message: '等级说明长度必须在256个字符内'
                        }
                    }
                },
            }
        });

        $("#submit-btn").click(function () {
            var $form = $("#post-form");

            $form.bootstrapValidator('validate');
            if ($form.data('bootstrapValidator').isValid()) {
                $form.submit();
            }
        })
    </script>
@endsection