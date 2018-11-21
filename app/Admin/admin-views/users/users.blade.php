@extends('admin::layouts.main')

@section('content')

    @include('admin::search.users-users')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">会员列表</h3>
                    @include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::users.index')])
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>昵称</th>
                            <th>等级</th>
                            <th>生日</th>
                            <th>联系方式</th>
                            <th>地址信息</th>
                            <th>成交</th>
                            <th>账户信息</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nickname }}</td>
                                <td>{{ $user->userLevel->name }}</td>
                                {{--<td>{{ $user->authWechat->open_id }}</td>--}}
                                <td>{{ $user->birthday }}</td>
                                <td>
                                    联系人：{{ $user->contact_person }}
                                    <br>
                                    手机号：{{ $user->phone }}
                                </td>
                                <td>
                                    区域：{{ $user->country }}&nbsp;{{ $user->province }}&nbsp;{{ $user->city }}
                                    <br>
                                    详细地址：{{ $user->detail_place }}
                                </td>
                                <td>
                                    订单数：{{ $user->orders->count() }}
                                    <br>
                                    金额： ￥{{ $user->orders->sum('price') }}
                                </td>
                                <td>
                                    积分：{{ $user->score }}
                                    <br>
                                    余额： ￥{{ $user->money }}
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin::users.edit', $user->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $users->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection