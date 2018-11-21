@extends('admin::layouts.main')

@section('content')

    @include('admin::search.userLevels-userLevels')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">会员等级列表</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::userLevels.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>

                    @include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::userLevels.index')])
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>等级</th>
                            <th>等级名称</th>
                            <th>升级说明</th>
                            <th>满足天数/月</th>
                            <th>每日消费金额</th>

                            <th>分类月消费金额</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($userLevels as $userLevel)
                            <tr>
                                <td>{{ $userLevel->level }}</td>
                                <td>{{ $userLevel->name }}</td>
                                <td>{{ $userLevel->upgrade_condition }}</td>
                                <td>{{ $userLevel->date_num }}</td>
                                <td>&yen;{{ $userLevel->date_money }}</td>
                                <td>&yen;{{ $userLevel->brands_money }}</td>
                                <td>{{ $userLevel->created_at }}</td>
                                <td>
                                    @if ($userLevel->level != 0)
                                        <a href="{{ route('admin::userLevels.edit', $userLevel->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-id="{{ $userLevel->id }}" class="grid-row-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                     @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $userLevels->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::userLevels.index')])

    <script>
        $("#filter-modal .submit").click(function () {
            $("#filter-modal").modal('toggle');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        $('#start').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale('zh-cn')
        });

        $('#end').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale('zh-cn')
        });
    </script>
@endsection