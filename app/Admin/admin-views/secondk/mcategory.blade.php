@extends('admin::layouts.main')

@section('content')

    {{--@include('admin::search.shops-shops')--}}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">秒杀分类列表</h3>
                    <div class="btn-group pull-right">
                        <a href="javascript:void(0);"  class="grid-row-store btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>分类名</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($mcategories as $mcategory)
                            <tr>
                                <td>{{$mcategory->id }}</td>
                                <td>{{ $mcategory->title }}</td>
                                <td>{{ $mcategory->created_at }}</td>
                                <td>
                                    <a href="javascript:void(0);" data-id="{{ $mcategory->id }}"  data-title="{{ $mcategory->title }}"class="grid-row-edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $mcategory->id }}" class="grid-row-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $mcategories->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::mcategory.index')])
    <script>


        $('.grid-row-store').unbind('click').click(function() {

            swal({
                    title: "请输入分类名",
                    type: "input",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确认",
                    closeOnConfirm: false,
                    cancelButtonText: "取消"
                },
                function(inputvalue){
                    if (inputvalue === false) return false;

                    if (inputvalue === "") {
                        swal.showInputError("请输入分类!");
                        return false
                    }
                    $.ajax({
                        method: 'post',
                        url: "{{route('admin::mcategory.store')}}",
                        data: {
                            _token:LA.token,
                            title:inputvalue
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');

                            if (typeof data === 'object') {
                                if (data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }
                        }
                    });
                });
        });

        $('.grid-row-edit').unbind('click').click(function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            swal({
                    title: "请输入分类名",
                    type: "input",
                    inputValue: title,
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确认",
                    closeOnConfirm: false,
                    cancelButtonText: "取消"
                },
                function(inputvalue){
                    if (inputvalue === false) return false;

                    if (inputvalue === "") {
                        swal.showInputError("请输入分类!");
                        return false
                    }
                    $.ajax({
                        method: 'put',
                        url: "/admin/mcategory" + '/' + id,
                    data: {
                            _token:LA.token,
                            title:inputvalue
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');

                            if (typeof data === 'object') {
                                if (data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }
                        }
                    });
                });
        });


    </script>
@endsection