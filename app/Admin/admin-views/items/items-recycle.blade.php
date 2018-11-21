@extends('admin::layouts.main')

@section('content')

    {{--@include('admin::search.items-items')--}}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">商品列表</h3>



                    {{--@include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::items.index')])--}}
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>图片</th>
                            <th>编号</th>
                            <th>商品标题</th>
                            <th>排序</th>
                            <th>销量</th>
                            <th>销售价</th>
                            <th>原价</th>
                            <th>库存</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        @inject('itemPresenter', "App\Admin\Presenters\ItemPresenter")
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{!! $itemPresenter->cover($item) !!}</td>
                                <td>{{ $item->sn }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->sort }}</td>
                                <td>{{ $item->sales_volume }}</td>
                                <td>{!! $itemPresenter->price($item) !!}</td>
                                <td>{!! $itemPresenter->originalPrice($item) !!}</td>
                                <td>{!! $itemPresenter->stock($item) !!}</td>
                                <td>{!! $itemPresenter->status($item) !!}</td>
                                <td>

                                        <a href="{{ route('admin::items.reduction', $item->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-recycle"></i>&nbsp;&nbsp;还原
                                        </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $items->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection