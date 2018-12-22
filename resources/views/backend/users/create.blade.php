@extends("adminlte::page")

@section("title",'增加后台用户')

@section('content_header')
    <h1>增加后台用户</h1>
@stop

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form class="form-horizontal" action="{{ url('backend/users/store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <input name="user_name" type="text" class="form-control" maxlength="30" placeholder="用户名" value="{{ old('user_name') }}">
                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('user_phone') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">手机号码</label>
                            <div class="col-sm-10">
                                <input name="user_phone" type="text" class="form-control" maxlength="11" placeholder="手机号码" value="{{ old('user_phone') }}">
                                @if ($errors->has('user_phone'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('user_phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('user_pwd') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input name="user_pwd" type="text" class="form-control" maxlength="30" placeholder="密码" value="{{ old('user_pwd') }}">
                                @if ($errors->has('user_pwd'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('user_pwd') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    @foreach($typeOpt as $key=>$item)
                                        <label><input type="radio" name="type" value="{{ $key }}" />{{ $item }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop