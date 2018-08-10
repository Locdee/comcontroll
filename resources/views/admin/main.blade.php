<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>欢迎使用 杭州网微信公众号后台管理系统！</h2>
            <p>登录次数：{{$admin->login_count}} ,上次登录IP：{{$admin->last_login_ip}} , 上次登录时间：{{$admin->last_login_time}}</p>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="middle-box text-center animated fadeInRightBig">
                    {{--<h3 class="font-bold">这里是页面内容</h3>--}}

                    {{--<div class="error-desc">--}}
                        {{--您可以在这里添加栅格，参考首页及其他页面完成不同的布局--}}
                        {{--<br/><a href="#" class="btn btn-primary m-t">打开主页</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="js/jquery.min.js?v=2.1.4"></script>
    <script src="js/bootstrap.min.js?v=3.3.6"></script>

    <!-- 自定义js -->
    <script src="js/content.js?v=1.0.0"></script>


</body>

</html>
