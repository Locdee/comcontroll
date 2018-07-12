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
            <h2>编辑奖品</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('prize.index',['activity_id'=>$ac_id])}}">浏览</a>
                </li>
                <li>
                    <strong>编辑</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('prize.index',['activity_id'=>$ac_id])}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center middle-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('prize.update',['id'=>$prize->id])}}" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">奖品名称：</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="prizename"  class="form-control" placeholder="请输入文本" value="{{ $prize->prizename }}">
                                <span class="help-block m-b-none">奖品名称</span>

                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">数量：</label>
                            <div class="col-sm-9">
                                <input id="name" type="number" min="0"  name="count"  class="form-control" placeholder="请输入文本" value="{{ $prize->count }}">
                                <span class="help-block m-b-none">奖品数量</span>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">权重：</label>
                            <div class="col-sm-9">
                                <input id="name" type="number" min="0"  name="weight"  class="form-control" placeholder="请输入文本" value="{{ $prize->weight }}">
                                <span class="help-block m-b-none">中奖概率=权重/总权重</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status">
                                    @foreach($status_arr as $key=>$i)
                                        <option value="{{$key}}" {{ $prize->status==$key?'selected':'' }} >{{$i}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">相关活动：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="activity_id">
                                    @foreach($activity_list as $n)
                                        <option value="{{$n->id}}" {{ $prize->activity_id==$n->id?'selected':'' }}>{{$n->activityname}}</option>
                                    @endforeach
                                </select>
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
            var redirectUrl = redirectUrl || '';
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
                    prizename: "required",
                    node_id: "required"
                },
                messages: {
                    name: icon + "请输入奖品名称",
                    node_id: icon + "请选择管理节点"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("prize.index",['activity_id'=>$ac_id])}}');
                }
            });

        });
    </script>

</body>

</html>
