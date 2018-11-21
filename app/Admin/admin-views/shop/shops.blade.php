@extends('admin::layouts.main')

@section('content')

    {{--@include('admin::search.shops-shops')--}}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">店铺列表</h3>
                    @include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::shops.index')])
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>店主</th>
                            <th>店铺名</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($shops as $shop)
                            <tr>
                                <td>{{ $shop->id }}</td>
                                <td><a>
                                        @if(Admin::user()->can('update', $shop->admin))
                                            <a href="{{ route('admin::users.edit', $shop->admin->id ) }}">
                                                {{ $shop->admin->name }}
                                            </a>
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin::shop.show', $shop->id) }}">
                                        {{ $shop->title }}
                                    </a>
                                </td>
                                <td>{{ $shop->created_at }}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $shops->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection