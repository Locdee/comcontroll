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
        <div class="col-sm-4">
            <h2>增加文章分类</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('article_class.index')}}">增加文章分类</a>
                </li>
                <li>
                    <strong>增加</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('article_class.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center middle-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('article_class.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">名称：</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="classname"  class="form-control" placeholder="请输入文本">
                                <span class="help-block m-b-none">分类名称</span>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">所在公众号：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="official_account_id">
                                    @foreach($official_list as $o)
                                        <option value="{{$o->id}}">{{$o->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态：</label>
                            <div class="col-sm-9">
                                @foreach($status_arr as $k=>$status)
                                    <label class="checkbox-inline">
                                        <input type="radio" name="status" value="{{ $k }}" required>{{ $status}}
                                    </label>
                                @endforeach
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
            $('input[name=all]').click(function(){
                if(this.checked){
//                    alert(12);
                    $("input[name='node_id[]']").prop("checked",true);
                    $(".node_action").prop("checked",true);

                }else{
//                    alert(34);
                    $("input[name='node_id[]']").prop("checked",false);
                    $(".node_action").prop("checked",false);
                }
            });
            $("input[name='node_id[]']").click(function(){
                if(this.checked){
                    $(this).parents(".node").find('.node_action').prop("checked",true);
                }else{
                    $(this).parents(".node").find('.node_action').prop("checked",false);
                }
            });
            $('.node_action').click(function(){
//                alert($(this).parents(".node").find('.node_action:checked').length);

                if(this.checked){
                    $(this).parents(".node").find("input[name='node_id[]']").prop("checked",true);
                }else if($(this).parents(".node").find('.node_action:checked').length==0){
                    $(this).parents(".node").find("input[name='node_id[]']").prop("checked",false);
                }
            });

            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    node_id: "required"
                },
                messages: {
                    name: icon + "请输入节点名称",
                    node_id: icon + "请选择管理节点"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("article_class.index")}}');
                }
            });

        });
    </script>

</body>

</html>
