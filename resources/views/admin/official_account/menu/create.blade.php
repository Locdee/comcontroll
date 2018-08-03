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


    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    <link href="{{asset('webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('webuploader/muti.css')}}" rel="stylesheet">
    <script src="{{asset('webuploader/webuploader.js')}}" type="text/javascript"></script>
</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>增加自动回复</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('wechat_menu.index')}}">浏览</a>
                </li>
                <li>
                    <strong>增加</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('wechat_menu.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center large-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('wechat_menu.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">关键词：</label>
                            <div class="col-sm-9">
                                <input id="key" type="text" name="key"  class="form-control" placeholder="请输入关键词">
                                <span class="help-block m-b-none">自动回复关键词</span>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">点击key值：</label>
                            <div class="col-sm-9">
                                <input id="click_key" type="text" name="click_key"  class="form-control" placeholder="请输入关键词">
                                <span class="help-block m-b-none">点击key值(和微信菜单栏中的click_key结合使用)</span>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">回复响应地址(如果填写则移交该链接处理请求)：</label>
                            <div class="col-sm-9">
                                <input id="external_link" type="text" name="external_link"  class="form-control" placeholder="回复响应地址" value="">
                                <span class="help-block m-b-none">回复响应地址</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">回复消息类型：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="msg_type">
                                    @foreach($msg_type_arr as $type)
                                        @if($type['disable']==1)
                                        <option value="{{$type['type']}}">{{$type['text']}}</option>
                                        @endif
                                    @endforeach
                                </select>
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
                                <select class="form-control" name="status">
                                    @foreach($status_arr as $k=>$status)
                                        <option value="{{ $k }}" >{{ $status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text_content reply">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">文本回复内容：</label>
                                <div class="col-sm-9">
                                    <input id="content" type="text" name="content"  class="form-control" placeholder="文本回复内容">
                                    <span class="help-block m-b-none">文本回复内容</span>
                                </div>
                            </div>
                        </div>
                        <div class="news reply">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">图文消息标题：</label>
                                <div class="col-sm-9">
                                    <input id="title" type="text" name="title"  class="form-control" placeholder="图文消息标题">
                                    <span class="help-block m-b-none">图文消息标题</span>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">图文消息描述：</label>
                                <div class="col-sm-9">
                                    <input id="description" type="text" name="description"  class="form-control" placeholder="图文消息描述">
                                    <span class="help-block m-b-none">图文消息描述</span>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">图文消息链接：</label>
                                <div class="col-sm-9">
                                    <input id="url" type="text" name="url"  class="form-control" placeholder="图文消息链接">
                                    <span class="help-block m-b-none">图文消息链接</span>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">图文消息显示图片(360*200显示效果最佳)：</label>
                                <input type="hidden" name="pic_url" value="">
                                <div class="col-sm-9">
                                    <div id="uploader-demo">
                                        <!--用来存放item-->
                                        <div id="fileList_pic_url" class="uploader-list">

                                        </div>
                                        <div id="filePicker_pic_url">选择图片</div>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                //上传
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                var uploader_pic_url = WebUploader.create({
                                    // 选完文件后，是否自动上传。
                                    auto: true,

                                    // swf文件路径
                                    swf: '{{asset('webuploader/Uploader.swf')}}',

                                    // 文件接收服务端。
                                    server: '{{route('image_upload')}}',

                                    // 选择文件的按钮。可选。
                                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                                    pick: '#filePicker_pic_url',

                                    // 只允许选择图片文件。
                                    accept: {
                                        title: 'Images',
                                        extensions: 'jpg,jpeg,png',
                                        mimeTypes: 'image/*'
                                    }
                                });
                                // 文件上传过程中创建进度条实时显示。
                                uploader_pic_url.on( 'uploadProgress', function( file, percentage ) {
                                    var $li = $( '#'+file.id ),
                                            $percent = $li.find('.progress span');

                                    // 避免重复创建
                                    if ( !$percent.length ) {
                                        $percent = $('<p class="progress"><span></span></p>')
                                                .appendTo( $li )
                                                .find('span');
                                    }

                                    $percent.css( 'width', percentage * 100 + '%' );
                                });

                                // 文件上传成功，给item添加成功class, 用样式标记上传成功。
                                uploader_pic_url.on( 'uploadSuccess', function( file, response ) {
//        $( '#'+file.id ).addClass('upload-state-done');
                                    $( '#'+file.id ).remove();
                                    uploader_pic_url.reset();
                                    if(response.status == 1){
                                        $("input[name=pic_url]").val(response.data);
                                        $("#fileList_pic_url").html("<img style='width: 110px;' src='"+response.data+"' >");
//            $().appendTo();
                                        $("#upload-tips1").remove();
                                    }else{
                                        alert(response.message);
                                    }
                                });

                                // 文件上传失败，显示上传出错。
                                uploader_pic_url.on( 'uploadError', function( file ) {
                                    var $li = $( '#'+file.id ),
                                            $error = $li.find('div.error');

                                    // 避免重复创建
                                    if ( !$error.length ) {
                                        $error = $('<div class="error"></div>').appendTo( $li );
                                    }

                                    $error.text('上传失败');
                                });

                                // 完成上传完了，成功或者失败，先删除进度条。
                                uploader_pic_url.on( 'uploadComplete', function( file ) {
                                    $( '#'+file.id ).find('.progress').remove();
                                });
                            </script>
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
            function reply_change(){
                var t = $('select[name=msg_type]').val();
                $('.reply').hide();
                switch(t){
                    case 'text':
                        $('.text_content').show();
                        break;
                    case 'news':
                        $('.news').show();
                        break;

                    case 'image':
                        break;
                    case 'voice':
                        break;
                    case 'music':
                        break;
                    case 'video':
                        break;

                    default:
                        break;
                }
            }
            setTimeout(reply_change,500);
            $('select[name=msg_type]').change(function(){
//                return;
                var t = $(this).val();
                $('.reply').hide();
                switch(t){
                    case 'text':
                        $('.text_content').show();
                        break;
                    case 'news':
                        $('.news').show();
                        break;

                    case 'image':
                        break;
                    case 'voice':
                        break;
                    case 'music':
                        break;
                    case 'video':
                        break;

                    default:
                        break;
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
                    Actionsubmit(form,'POST','{{route("wechat_menu.index")}}');
                }
            });

        });
    </script>

</body>

</html>
