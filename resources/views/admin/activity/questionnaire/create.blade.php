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

    {{--时间插件--}}
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/datapicker/datetimepicker.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>增加题目</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('questionnaire.index')}}">浏览</a>
                </li>
                <li>
                    <strong>增加题目</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('questionnaire.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center larger-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('questionnaire.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="col-md-12">


                        <div class="form-group">
                            <label class="col-sm-3 control-label">所属活动：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="activity_id">
                                    @foreach($activity_list as $o)
                                        <option value="{{$o->id}}">{{$o->activityname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">题目内容：</label>
                            <div class="col-sm-9">
                                <textarea name="question" style="width: 100%;height: 155px"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">题型：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type">
                                    @foreach($type_arr as $key=>$i)
                                        <option value="{{$key}}">{{$i}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="choice_block" style="background-color: lightyellow">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">选项A：</label>
                                <div class="col-sm-9 answer_block">
                                    <input id="name" type="text" name="anser_iterm_A"  class="form-control" placeholder="请输入文本">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">选项B：</label>
                                <div class="col-sm-9 answer_block">
                                    <input id="name" type="text" name="anser_iterm_B"  class="form-control" placeholder="请输入文本">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">选项C：</label>
                                <div class="col-sm-9 answer_block">
                                    <input id="name" type="text" name="anser_iterm_C"  class="form-control" placeholder="请输入文本">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">选项D：</label>
                                <div class="col-sm-9 answer_block">
                                    <input id="name" type="text" name="anser_iterm_D"  class="form-control" placeholder="请输入文本">

                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">选项E：</label>
                                <div class="col-sm-9 answer_block">
                                    <input id="name" type="text" name="anser_iterm_E"  class="form-control" placeholder="请输入文本">

                                </div>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-3 control-label">正确答案(多选用英文逗号分隔)：</label>
                            <div class="col-sm-9" id="choise_right_answer">
                                <input id="name" type="text" name="right_answer_choise"  class="form-control" placeholder="请输入文本">
                                <span class="help-block m-b-none">多选用英文逗号分隔</span>
                            </div>
                            <div class="col-sm-9 " id="judge_answer">
                                <label><input type="radio" name="right_answer_judge" value="right">对</label>
                                <label><input type="radio" name="right_answer_judge" value="wrong">错</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">答案解析：</label>
                            <div class="col-sm-9">
                                <textarea name="explain" style="width: 100%;height: 155px"></textarea>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">得分：</label>
                            <div class="col-sm-9">
                                <input id="score" type="number" name="score"  class="form-control" placeholder="请输入得分" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态：</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control help-block m-b-none">
                                    @foreach($status_arr as $k=>$status)
                                        <option value="{{ $k }}">{{$status}}</option>
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
    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/js/plugins/datetimepicker/jquery.datetimepicker.full.js')}}"></script>

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
                    question: "required"
                },
                messages: {
                    question: icon + "请输入题目内容"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("questionnaire.index")}}');
                }
            });

            $('select[name=type]').change(function(){
                var t = $(this).val();
                if(t=='1'||t=='2'){
                    $('#choice_block').show();
                    $('#choise_right_answer').show();
                    $('#judge_answer').hide();
                }else{
                    $('#choice_block').hide();
                    $('#choise_right_answer').hide();
                    $('#judge_answer').show();
                }
            }).trigger('change');

        });
    </script>

</body>

</html>
