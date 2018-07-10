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
            <h2>增加活动</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('activity.index')}}">浏览</a>
                </li>
                <li>
                    <strong>编辑活动</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('activity.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center larger-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('activity.update',['id'=>$activity->id])}}" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">活动名称：</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="activityname"  class="form-control" placeholder="请输入文本" value="{{$activity->activityname}}">
                                <span class="help-block m-b-none">活动名称</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">所在公众号：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="official_account_id">
                                    @foreach($official_list as $o)
                                        <option value="{{$o->id}}" {{$activity->official_account_id==$o->id?'selected':''}}>{{$o->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <label class="col-sm-3 control-label">活动类型：</label>
                        <div class="col-sm-9">
                            <label class="checkbox-inline">
                                <input name="is_register" type="checkbox" value="1" id="is_register" {{$activity->is_register==1?'checked':''}}>信息采集(报名，征稿等)</label>
                            <label class="checkbox-inline">
                                <input name="is_vote" type="checkbox" value="1" id="is_vote" {{$activity->is_vote==1?'checked':''}}>投票</label>
                            <label class="checkbox-inline">
                                <input name="is_lottery" type="checkbox" value="1" id="is_lottery" {{$activity->is_lottery==1?'checked':''}}>抽奖</label>
                            <label class="checkbox-inline">
                                <input name="is_questionnaire" type="checkbox" value="1" id="is_questionnaire" {{$activity->is_questionnaire==1?'checked':''}}>答题</label>
                        </div>
                        <div class="register_part">
                            <div class="form-group" id="data_5">
                                <label class="col-sm-3 control-label">信息采集时间段:</label>
                                <div class="input-daterange input-group" id="">
                                    <input type="text" class="input-sm form-control"name="register_start_time" value="{{ date('Y-m-d',$activity->register_start_time) }}" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control" name="register_end_time" value="{{ date('Y-m-d',$activity->register_end_time) }}" />
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-w-m btn-success" id="add_element">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true">添加采集要素</span>
                                </button>
                            </div>
                            <div id="element_list" style="background-color: #7fe3e9">
                                @foreach($activity->register_content as $element)
                                    <div class="element">
                                        <div class="form-group" >
                                            <label class="col-sm-3 control-label">要素名称：</label>
                                            <div class="col-sm-3">
                                                <input id="name" type="text" name="element_name[]"  class="form-control" placeholder="请输入文本" value="{{$element->name}}">
                                                <span class="help-block m-b-none">需要采集的要素名称</span>
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label class="col-sm-3 control-label">类型：</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="element_type[]">
                                                    @foreach($register_element_type_arr as $key=>$i)
                                                        <option value="{{$key}}" {{ $element->type==$key?'selected':'' }}>{{$i}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-w-m btn-warning element_remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="vote_part">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">投票频率：</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="vote_times">
                                        @foreach($vote_times_arr as $key=>$i)
                                            <option value="{{$key}}" {{$activity->vote_times==$key?'selected':''}}>{{$i}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="">
                                <label class="col-sm-3 control-label">投票时间段:</label>
                                <div class="input-daterange input-group" id="">
                                    <input type="text" class="input-sm form-control" name="vote_start_time" value="{{ date('Y-m-d',$activity->vote_start_time) }}" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control" name="vote_end_time" value="{{ date('Y-m-d',$activity->vote_end_time) }}" />
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">每人投票次数：</label>
                                <div class="col-sm-3">
                                    <input id="vote_times" type="number" name="vote_times" min="1"  class="form-control" placeholder="请输入文本">
                                    <span class="help-block m-b-none">个人每天或总的投票次数</span>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">候选人重复投票次数：</label>
                                <div class="col-sm-3">
                                    <input id="vote_repeat_times" type="number" name="vote_repeat_times" min="1"  class="form-control" placeholder="请输入数字">
                                    <span class="help-block m-b-none">个人每天或总的对同一候选人的投票次数</span>
                                </div>
                            </div>

                        </div>
                        <div class="lottery_part">
                            <div class="form-group" id="">
                                <label class="col-sm-3 control-label">抽奖时间段:</label>
                                <div class="input-daterange input-group" id="">
                                    <input type="text" class="input-sm form-control" name="lottery_start_time" value="{{ date('Y-m-d',$activity->lottery_start_time) }}" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control" name="lottery_end_time" value="{{ date('Y-m-d',$activity->lottery_end_time) }}" />
                                </div>
                            </div>

                        </div>
                        <div class="questionnaire_part">
                            <div class="form-group" id="">
                                <label class="col-sm-3 control-label">答题时间段:</label>
                                <div class="input-daterange input-group" id="">
                                    <input type="text" class="input-sm form-control"  name="questionnaire_start_time" value="{{ date('Y-m-d',$activity->questionnaire_start_time) }}" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control"  name="questionnaire_end_time" value="{{ date('Y-m-d',$activity->questionnaire_end_time) }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">活动状态：</label>
                            <div class="col-sm-9">
                                @foreach($status_arr as $k=>$status)
                                <label class="checkbox-inline">
                                    <input type="radio" name="status" value="{{ $k }}" required {{$activity->status==$k?'checked':''}}>{{ $status}}
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
                    name: "required",
                    model: "required"
                },
                messages: {
                    name: icon + "请输入节点名称",
                    model: icon + "请输入模型名"
                },
                submitHandler:function(form){
                    Actionsubmit(form,'POST','{{route("activity.index")}}');
                }
            });
            $('input[name=is_register]').is(':checked')?$('.register_part').show():$('.register_part').hide();
            $('input[name=is_vote]').is(':checked')?$('.vote_part').show():$('.vote_part').hide();
            $('input[name=is_lottery]').is(':checked')?$('.lottery_part').show():$('.lottery_part').hide();
            $('input[name=is_questionnaire]').is(':checked')?$('.questionnaire_part').show():$('.questionnaire_part').hide();

            $('input[name=is_register]').click(function(){
                if($(this).is(':checked')){
                    $('.register_part').show();
                }else{
                    $('.register_part').hide();
                }
            });
            $('input[name=is_vote]').click(function(){
                if($(this).is(':checked')){
                    $('.vote_part').show();
                }else{
                    $('.vote_part').hide();
                }
            });

            $('input[name=is_lottery]').click(function(){
                if($(this).is(':checked')){
                    $('.lottery_part').show();
                }else{
                    $('.lottery_part').hide();
                }
            });
            $('input[name=is_questionnaire]').click(function(){
                if($(this).is(':checked')){
                    $('.questionnaire_part').show();
                }else{
                    $('.questionnaire_part').hide();
                }
            });
            //时间选择
            $('.register_part .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
            $('.vote_part .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
            $('.lottery_part .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('.questionnaire_part .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#add_element').click(function(){
                $('#element_list').append(`
                    <div class="element">
                                        <div class="form-group" >
                                            <label class="col-sm-3 control-label">要素名称：</label>
                                            <div class="col-sm-3">
                                                <input id="name" type="text" name="element_name[]"  class="form-control" placeholder="请输入文本">
                                                <span class="help-block m-b-none">需要采集的要素名称</span>
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label class="col-sm-3 control-label">类型：</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="element_type[]">
                                                    @foreach($register_element_type_arr as $key=>$i)
                            <option value="{{$key}}">{{$i}}</option>
                                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-w-m btn-warning element_remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                </div>
            `);
            });
            $('#element_list').on('click','.element_remove',function(){
                $(this).parent().remove();
            });
        });
    </script>

</body>

</html>
