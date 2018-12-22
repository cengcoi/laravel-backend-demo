@extends("adminlte::page")

@section("title",'后台用户详情')

@section('content_header')
    <h1>后台用户详情</h1>
@stop

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form class="form-horizontal" action="" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <p class="form-control">{{ $data->user_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机号码</label>
                            <div class="col-sm-10">
                                <input name="user_phone" type="text" class="form-control" maxlength="11" placeholder="手机号码" value="{{ $data->user_phone }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码修改</label>
                            <div class="col-sm-10">
                                <input name="user_pwd" type="text" class="form-control" maxlength="30" placeholder="新密码" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    @foreach($typeOpt as $key=>$item)
                                        <label><input type="radio" name="type" value="{{ $key }}"{{ $data->type == $key ? ' checked="checked':'' }} />{{ $item }}</label>
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
@section("js")
    <script type="text/javascript">
        $(function(){

        });
    </script>
@stop