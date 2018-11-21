@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑售后规则</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::afterSaleRule.update',$saleRule->id) }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                    <label for="name" id="labelId" class="col-sm-2 control-label">售后规则</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                        <div id="editor">
                                            {!! $saleRule->content !!}
                                        </div>
                                        <span id="error-info" style="font-size:85%;color:#a94442"></span>
                                        <textarea name="content" id="content"  hidden>{{ $saleRule->content }}</textarea>
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
                            <span id="prompt-info" style="color:#f00;"></span>
                            <button type="button" id="submit-btn"  class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">提交</button>
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
                location.reload();
            });

            ///
            var menus = [
                'head',  // 标题
                'bold',  // 粗体
                'fontSize',  // 字号
                'fontName',  // 字体
                'italic',  // 斜体
                'underline',  // 下划线
                'strikeThrough',  // 删除线
                'foreColor',  // 文字颜色
                'backColor',  // 背景颜色
                'link',  // 插入链接
                'list',  // 列表
                'justify',  // 对齐方式
                'quote',  // 引用
                'emoticon',  // 表情
                'image',  // 插入图片
                'code',  // 插入代码
                'undo',  // 撤销
                'redo'  // 重复
            ];

            var $details = $("#content");
            var editor = new wangEditor('#editor');
            editor.customConfig.zIndex = 100;
            editor.customConfig.menus = menus;
            editor.customConfig.uploadImgShowBase64 = true;
            editor.customConfig.uploadFileName = 'imgs[]';
            editor.customConfig.showLinkImg = false;
            editor.customConfig.uploadImgServer = "{{ route('admin::upload.image') }}";
            editor.customConfig.uploadImgParams = {
                _token:LA.token
            };
            editor.customConfig.onchange = function (html) {
                $details.val(html);
            };

            editor.create();

            $('#submit-btn').on('click', function (event) {
                $('#post-form').submit();
                swal("提交成功！","请继续操作！","success");
            });
        });
    </script>
@endsection