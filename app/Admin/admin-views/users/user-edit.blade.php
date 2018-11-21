@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑会员</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::users.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::users.update',$user->id) }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">会员昵称</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="name" value="{{ $user->nickname }}" readonly class="form-control" placeholder="输入 昵称">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="level" class="col-sm-2 control-label">会员等级</label>
                                <div class="col-sm-8">
                                    <select style="width: 100%;" name="level" id="level" tabindex="-1" data-placeholder="选泽会员等级" class="form-control level select2-hidden-accessible">
                                        @foreach($userLevels as $level)
                                            <option value="{{ $level->level }}" @if($user->level == $level->level) selected @endif>{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthday" class="col-sm-2 control-label">生日</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" id="birthday" name="birthday" value="{{ $user->birthday }}" class="form-control" placeholder="输入 生日">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_person" class="col-sm-2 control-label">联系人</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input name="contact_place" id="contact_place" value="{{ $user->contact_place }}" class="form-control" placeholder="联系人">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">联系方式</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input name="phone" id="phone" value="{{ $user->phone }}" class="form-control" placeholder="联系方式">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="detail_place" class="col-sm-2 control-label">详细地址</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input name="detail_place" id="detail_place" class="form-control" value="{{ $user->detail_place }}" placeholder="详细地址">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="score" class="col-sm-2 control-label">积分</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input name="score" id="score" class="form-control" value="{{ $user->score }}" placeholder="积分">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="money" class="col-sm-2 control-label">余额</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input name="money" id="money" value="{{ $user->money }}" class="form-control" placeholder="余额">
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
                history.back();
            });

            $(".level").select2({
                "allowClear": true
            });

            $("#post-form").bootstrapValidator({
                live: 'enable',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    contact_person:{
                        validators:{
                            stringLength: {
                                max: 20,
                                message: '联系人长度不能超过20个字符'
                            },
                            regexp: {
                                regexp:/^[\u4E00-\u9FA5\w]+$/,
                                message: '所输入用户名含有非法字符'
                            },
                        }
                    },
                    phone:{
                        validators:{
                            regexp: {
                                regexp: /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/,
                                message: '所输入手机号不符合规则'
                            },
                        }
                    },
                    detail_place:{
                        validators:{
                            stringLength: {
                                max: 64,
                                message: '详细地址不能超过64个字符'
                            },
                        }
                    }
                }
            });

            $("#score").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $("#money").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $('#birthday').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: moment.locale('zh-cn')
            });

            $("#submit-btn").click(function () {
                var $form = $("#post-form");

                $form.bootstrapValidator('validate');
                if ($form.data('bootstrapValidator').isValid()) {
                    $form.submit();
                }
            })
        });
    </script>
@endsection