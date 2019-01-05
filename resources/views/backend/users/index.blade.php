@extends('adminlte::page')

@section('title', '后台用户列表')

@section('content_header')
    <h1>后台用户列表</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <form class="form-horizontal">
                        <div class="box-body col-md-4 no-padding">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">用户名</label>
                                <div class="col-sm-8">
                                    <input type="text" name="user_name" class="form-control" id="title" value="{{ $filter['user_name'] or '' }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-body col-md-4 no-padding">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">状态</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="status">
                                        <option value="">--</option>
                                        <option value="0"@if(isset($filter['status']) && 0 == $filter['status']) selected="selected"@endif>正常</option>
                                        <option value="1"@if(isset($filter['status']) && 1 == $filter['status']) selected="selected"@endif>未审核</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-body col-md-4">
                            <div class="form-group">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <a href="{{ url("backend/users/create") }}" class="btn btn-success pull-right">新增</a>
                                </div>
                                <div class="col-sm-3">
                                    <a href="{{ url("backend/users") }}" class="btn btn-primary pull-right">重置</a>
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-info pull-right">搜索</button>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 140px">#</th>
                            <th style="width: 150px">用户名</th>
                            <th style="width: 80px;">手机号码</th>
                            <th>类型</th>
                            <th>状态</th>
                            <th>角色</th>
                            <th>创建时间</th>
                            <th style="width: 120px">操作</th>
                        </tr>
                        @foreach($data->items() as $item)
                            <tr>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->user_name }}</td>
                                <td>{{ $item->user_phone }}</td>
                                <td>{{ $typeOpt[$item->type] }}</td>
                                <td>{{ $statusOpt[$item->status] }}</td>
                                <td>{{ $item->role_id }}</td>
                                <td>{{ $item->create_time }}</td>
                                <td>
                                    <a href="{{ url("backend/users/".$item->user_id) }}" target="_blank">修改</a>
                                    @if($item->status == 1)
                                        <a class="ajax" href="{{ url("backend/users/check") }}" value="{{ $item->user_id }}">审核通过</a>
                                    @else
                                        <a class="ajax" href="{{ url("backend/users/delete") }}" value="{{ $item->user_id }}">删除</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{$data->total()}}条数据 {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("css")
@stop
@section("js")
@stop