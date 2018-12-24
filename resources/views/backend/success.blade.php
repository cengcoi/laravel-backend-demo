@extends('adminlte::page')

@section('title', $msg)

@section('content')
    <div class="error-page">
        <h2 class="headline">
            <i class="fa fa-smile-o text-green"></i>
        </h2>
        <div class="error-content">
            <h3>{{ $msg }}</h3>
            <p id="msg"><i id="sec">3</i>秒后跳转...</p>
            <div>
                <a href="{{ $url }}" class="btn btn-success">跳转</a>
            </div>
        </div>

    </div>
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            var seconds = $("#sec").text();

            function timeOut(){
                if(seconds >0){
                    setTimeout(function () {
                        $("#sec").text(--seconds);
                        timeOut();
                    },1000)
                }else{
                    location.href="{{ $url }}"
                }

            }
            timeOut();
        });
    </script>
@stop
