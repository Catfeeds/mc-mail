@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::topics.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::topics.update', $topic->id) }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">专题名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="name" name="name" value="{{ $topic->name }}" class="form-control name" placeholder="输入 名称">
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group  ">--}}
                                {{--<label for="items" class="col-sm-2 control-label">商品集合</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<select class="form-control items" style="width: 100%;" name="items[]" multiple="multiple" data-placeholder="输入 权限"  >--}}
                                        {{--@foreach($items as $item)--}}
                                            {{--<option value="{{ $item->id }}" {{ in_array($item->id, $topic->items->pluck('id')->all()) ? 'selected' : '' }}>--}}
                                                {{--{{ $item->title }}--}}
                                            {{--</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">标签</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="label" name="label" value="{{ $topic->label }}" class="form-control name" placeholder="输入 标签">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">分类</label>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%;" name="mcategory_id" data-placeholder="选择 分类"  >
                                        <option value="">请选择</option>
                                        @foreach($mcategories as $mcategory)
                                            <option value="{{  $mcategory->id }}" @if($mcategory->id == $topic->mcategory_id) selected @endif>{{  $mcategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">秒杀点</label>
                                <div class="col-sm-8">
                                    <div class="input-group kt" >

                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">自动取消</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="label" name="canceltime" value="{{$topic->canceltime}}" class="form-control name" placeholder="输入 自动取消时间">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" class="status la_checkbox" @if($topic->status == 1)checked @endif/>
                                    <input type="hidden" class="status" name="status" value="1"/>
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

        $('.items').bootstrapDualListbox({
            "infoText": "text_total",
            "infoTextEmpty": "text_empty",
            "infoTextFiltered": "过滤",
            "filterTextClear": "清除",
            "filterPlaceHolder": "搜索"
        });

        var str='';
        var arr =[];
        arr="{{$killtimes}}";

        for(var i=0;i<=23;i++){

            if(arr.indexOf(i)!=-1){
                str+=
                    "                                            <input type=\"checkbox\" name=\"killtime[]\" "+"value=\" "+i+"\""+ "checked >"+i+"点\n";
            }
            else {
                str +=
                    "                                            <input type=\"checkbox\" name=\"killtime[]\" " + "value=\" " + i + "\"" + ">" + i + "点\n";
            }
        }
        $('.kt').html(str);

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
                            message: '名称不能为空'
                        }
                    }
                },
                label:{
                    validators:{
                        notEmpty:{
                            message: '标签不能为空'
                        }
                    }
                },
                mcategory_id:{
                    validators:{
                        notEmpty:{
                            message: '分类不能为空'
                        }
                    }
                },
                killtime:{
                    validators:{
                        notEmpty:{
                            message: '秒杀点不能为空'
                        }
                    }
                },
                canceltime:{
                    validators:{
                        notEmpty:{
                            message: '自动取消不能为空'
                        }
                    }
                }

            }

        });


        $('.status.la_checkbox').bootstrapSwitch({
            size:'small',
            onText: '启动',
            offText: '关闭',
            onColor: 'primary',
            offColor: 'danger',
            onSwitchChange: function(event, state) {
                $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
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