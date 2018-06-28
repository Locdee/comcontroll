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
            <h2>增加公众号信息</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('official_account.index')}}">浏览公众号信息</a>
                </li>
                <li>
                    <strong>修改公众号信息</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('node.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center middle-box "style="margin-top: 20px; max-width: 600px">
                    <form id="signupForm" method="post" action="{{route('official_account.update',['id'=>$account->id])}}" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">公众号名称：</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="name"  class="form-control" placeholder="请输入文本" value="{{$account->name}}">
                                <span class="help-block m-b-none">公众号名称</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Appid：</label>
                            <div class="col-sm-9">
                                <input id="appid" type="text" name="appid"  class="form-control" placeholder="请输入Appid" value="{{$account->appid}}">
                                <span class="help-block m-b-none">Appid</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">AppSecret：</label>
                            <div class="col-sm-9">
                                <input id="appsecret" type="text" name="appsecret"  class="form-control" placeholder="请输入Appscret" value="{{$account->appsecret}}">
                                <span class="help-block m-b-none">AppSecret</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Token：</label>
                            <div class="col-sm-9">
                                <input id="token" type="text" name="token"  class="form-control" placeholder="请输入Token"  value="{{$account->token}}">
                                <span class="help-block m-b-none">token</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">AesKey：</label>
                            <div class="col-sm-9">
                                <input id="aes_key" type="text" name="aes_key"  class="form-control" placeholder="请输入AesKey"   value="{{$account->aes_key}}">
                                <span class="help-block m-b-none">AesKey</span>
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="col-sm-3 control-label">相关编辑人员：</label>

                            <div class="col-sm-9 text-left">
                                <label class="checkbox">
                                    <input type="checkbox" name="all" >全选
                                </label>

                                <div class="checkbox-inline">
                                    @foreach($admin_list as $admin)
                                        <label style="width: 60px">
                                            <input type="checkbox" name="admin_id[]" value="{{ $admin->id }}" @if($account->admin()->wherePivot('admin_id',$admin->id)->count()) checked @endif>{{ $admin->name }}
                                        </label>
                                    @endforeach
                                </div>
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
                    $("input[name='admin_id[]']").prop("checked",true);


                }else{
//                    alert(34);
                    $("input[name='admin_id[]']").prop("checked",false);

                }
            });

            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    appid: "required",
                    appsecret:"required"
                },
                messages: {
                    name: icon + "请输入公众号信息名称",
                    appid: icon + "请输入Appid",
                    appsecret:icon + "请输入AppSecret"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("official_account.index")}}');
                }
            });

        });
    </script>

</body>

</html>
