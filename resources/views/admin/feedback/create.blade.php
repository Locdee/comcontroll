<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    @include('vendor.ueditor.assets')
    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>提交后台反馈</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('admin_feedback.index')}}">浏览后台反馈</a>
                </li>
                <li>
                    <strong>提交后台反馈</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('admin_feedback.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center larger-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('admin_feedback.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">相关描述：</label>
                            <div class="col-sm-9" style="height: 800px">
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                    var ue = UE.getEditor('container');
                                    ue.ready(function() {
                                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                                    });
                                </script>

                                <!-- 编辑器容器 -->
                                <script id="container" name="content" type="text/plain"></script>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <button class="btn btn-white" type="reset">重置</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    <!-- 自定义js -->
    <script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
    <script src="{{asset('admin/js/jquery.form.js')}}"></script>
    {{--弹出js--}}
    <script src="{{asset('admin/plugins/layer/layer.js')}}"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/messages_zh.min.js')}}"></script>
    <script type="text/javascript">
        //以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none"


        });
        function Actionsubmit(form,type,redirectUrl) {
            var redirectUrl = redirectUrl || ''
            $(form).ajaxSubmit({
                type: type,
                dataType: 'json',
                url: $(form).attr('action'),
                success: function (result) {
                    if (result.status == 1) {
                        layer.open({
                            title:"成功",
                            content:result.message,
                            end:function(){
                                window.location=redirectUrl;
                            },
                        });
                    } else {
                        layer.open({
                            title:"失败",
                            content:result.message
                        });
                    }
                },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //laravel  验证错误信息 ，ajax返回
                    var request = XmlHttpRequest;
                    if (request.status == 422) {
                        var data = $.parseJSON(request.responseText);
                        for (var o in data) {
                            app.fail(data[o][0]);
                            return false;
                        }
                    } else {
                        alert('请联系管理员');
                    }
                }
            });
        }
        //以下为官方示例
        $().ready(function () {


            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    model: "required"
                },
                messages: {
                    name: icon + "请输入后台反馈名称",
                    model: icon + "请输入模型名"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("admin_feedback.index")}}');
                }
            });

        });
    </script>

</body>

</html>
