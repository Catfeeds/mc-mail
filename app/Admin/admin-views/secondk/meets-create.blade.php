@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">创建</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::meets.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::meets.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">会场名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 名称">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">专题</label>
                                <div class="col-sm-8">
                                    <select class="form-control topics" style="width: 100%;" name="topic_id" data-placeholder="选择 专题"  >
                                        <option value="">请选择</option>
                                        @foreach($topics as $topic)
                                            <option value="{{  $topic->id }}">{{  $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">选择时间段</label>
                                <div class="col-sm-4">
                                    {{--<table class="table">--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>专题名</th>--}}
                                            {{--<th>标签</th>--}}
                                            {{--<th>会场数</th>--}}
                                            {{--<th>状态</th>--}}
                                            {{--<th>创建时间</th>--}}
                                            {{--<th>修改时间</th>--}}
                                            {{--<th>操作</th>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                    <select class="form-control time" style="width: 100%;" name="time" data-placeholder="选择 时间段"  >
                                        <option value="">请选择</option>
                                        {{--@foreach($topics as $topic)--}}
                                            {{--<option value="{{  $topic->id }}">{{  $topic->name }}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="button" value="添加时间点" class="btn btn-info pull-right addtimek"  data-loading-text="<i class='fa fa-spinner fa-spin'></i> 添加时间点">
                                </div>
                            </div>

                            <div class="form-group addtime">

                            </div>




                            {{--<div class="form-group">--}}
                                {{--<label for="items" class="col-sm-2 control-label">商品集合</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<select class="form-control items" style="width: 100%;" name="items[]" multiple="multiple" data-placeholder="输入 权限"  >--}}
                                        {{--@foreach($items as $item)--}}
                                            {{--<option value="{{ $item->id }}" >{{ $item->title }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                    </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg" >
                                <div class="modal-content">
                        <div class="box-body table-responsive no-padding "  >
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>图片</th>
                                    <th>编号</th>
                                    <th>商品标题</th>
                                    <th>分类</th>
                                    <th>销售价</th>
                                    <th>原价</th>
                                    <th>库存</th>
                                    <th>状态</th>
                                </tr>
                                @inject('itemPresenter', "App\Admin\Presenters\ItemPresenter")
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{!! $itemPresenter->cover($item) !!}</td>
                                        <td>{{ $item->sn }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{!! $itemPresenter->price($item) !!}</td>
                                        <td>{!! $itemPresenter->originalPrice($item) !!}</td>
                                        <td>{!! $itemPresenter->stock($item) !!}</td>
                                        <td>{!! $itemPresenter->status($item) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            提交更改
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">重置</button>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="button" value="提交" id="submit-btn" class="btn btn-info pull-right"  data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
                        </div>
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



            $("#submit-btn").click(function () {
                var $form = $("#post-form");

                $form.bootstrapValidator('validate');
                if ($form.data('bootstrapValidator').isValid()) {
                    $form.submit();
                }
            })

            $('.form-history-back').on('click', function (event) {
                event.preventDefault();
                history.back(1);
            });





            $('.topics').change(function(){
                var id = $(this).val();
                $('.addtime').html('');
                if(id==''){
                    $(".time").html(" <option value=\"\">请选择</option>");
                }
               // console.log(id);
                $.ajax({
                    type:"get",
                    dataType:"json",
                    url:"/admin/topics/"+id,
                    success: function(data){
                     //    console.log(data)
                        var str=" <option value=\"\">请选择</option>";
                        for(var i=0;i<data.length;i++){
                            str = str+" <option value='"+data[i]+"' >"+data[i]+"点</option>"
                        }
                        $(".time").html(str);
                    }
                });
            });
            $('.addtimek').click(function(){
                var id = $('.time').val();
                if($('.addtime').html().indexOf(id+"点")==-1 && id!='') {

                    $('.addtime').append("<div class=\"form-group item"+id+" \">  <label for=\"name\" class=\"col-sm-3 control-label\">时间" + id + "点</label>\n "+" <span class=\"input-group-btn\">\n" +
                        "                                    <button id=\"search_btn\" data-toggle=\"modal\" data-target=\"#myModal\" class=\"btn btn-default "+"ktime"+id+"\"  type=\"button\" data-toggle=\"modal\" data-target=\"#myModal\" value=\"添加商品\">\n" +
                        "                                    添加商品\n" +
                        "                                    </button>\n" +
                        "                                </span></div>\n");
                }

                    $(".ktime"+id).click(function(){
                        // $('.item'+id).append(" <div id=\"list-view\" class =\"col-sm-12\" style=\"overflow-y:auto;height: 300px\">\n" +
                        //     "                                <table class=\"table\">\n" +
                        //     "                                    <tbody id=\"list_menu\">\n" +
                        //     "                                    <tr>\n" +
                        //     "                                        <th>ID</th>\n" +
                        //     "                                        <th>图片</th>\n" +
                        //     "                                        <th>编号</th>\n" +
                        //     "                                        <th>商品标题</th>\n" +
                        //     "                                        <th>状态</th>\n" +
                        //     "                                    </tr>\n" +
                        //     "                                    </tbody>\n" +
                        //     "                                </table>\n" +
                        //     "                            </div>\n" +
                        //     "                            <div id=\"list-btn\">\n" +
                        //     "                            </div>\n" +
                        //     "                        </div>");
                    });
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
                                message: '名称不能为空'
                            }
                        }
                    },
                    topic_id:{
                        validators:{
                            notEmpty:{
                                message: '分类不能为空'
                            }
                        }
                    }

                }

            });



        });

    </script>
@endsection