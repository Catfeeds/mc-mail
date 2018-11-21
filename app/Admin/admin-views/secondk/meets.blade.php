@extends('admin::layouts.main')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">会场列表</h3>

                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::meets.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>


                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>会场名</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($meets as $meet)
                            <tr>
                                <td>{{ $meet->id }}</td>
                                <td>{{  $meet->name }}</td>
                                <td>{{  $meet->created_at }}</td>
                                <td>{{  $meet->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin::meets.edit', $meet->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $meet->id }}" class="grid-row-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $meets->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::meets.index')])
@endsection