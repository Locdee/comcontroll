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

    {{--时间插件--}}
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/datapicker/datetimepicker.css')}}" rel="stylesheet">

    <link href="{{asset('webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('webuploader/muti.css')}}" rel="stylesheet">
    <script src="{{asset('webuploader/webuploader.js')}}" type="text/javascript"></script>
    @include('vendor.ueditor.assets')
</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>增加咨询</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('article.index')}}">浏览</a>
                </li>
                <li>
                    <strong>增加</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{route('article.index')}}" class="btn btn-primary">返回</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">

                <div class=" text-center large-box "style="margin-top: 20px">
                    <form id="signupForm" method="post" action="{{route('article.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">标题：</label>
                            <div class="col-sm-9">
                                <input id="title" type="text" name="title"  class="form-control" placeholder="请输入标题">
                                <span class="help-block m-b-none">标题</span>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">简介：</label>
                            <div class="col-sm-9">
                                <textarea name="intr" style="width: 100%;height: 155px"></textarea>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">作者：</label>
                            <div class="col-sm-9">
                                <input id="author" type="text" name="author"  class="form-control" placeholder="咨询作者">
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-3 control-label">链接：</label>
                            <div class="col-sm-9">
                                <input id="url" type="text" name="url"  class="form-control" placeholder="外部咨询地址" value="">
                            </div>
                        </div>
                        <div class="text_content reply">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">来源：</label>
                                <div class="col-sm-9">
                                    <input id="source" type="text" name="source"  class="form-control" placeholder="咨询来源">
                                </div>
                            </div>
                        </div>
                        <div class="lottery_part">
                            <div class="form-group" id="">
                                <label class="col-sm-3 control-label">发布时间:</label>
                                <div class="input-daterange input-group" id="">
                                    <input type="text" id="publish_time" class="input-sm form-control" placeholder="请选择时间" name="publish_time" value="{{ date('Y-m-d H:i') }}" />
                                </div>
                            </div>

                        </div>
                            <div class="form-group" >
                                <label class="col-sm-3 control-label">显示顺序：</label>
                                <div class="col-sm-9">
                                    <input id="listindex" type="number" name="listindex"  class="form-control" placeholder="显示顺序">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">分类：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="class_id">
                                    @foreach($article_class_list as $c)
                                        <option value="{{$c->id}}" {{$class_id==$c->id?'selected':''}}>{{$c->classname}}({{$c->official->name}})</option>
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


                            <div class="form-group" >
                                <label class="col-sm-3 control-label">图片：</label>
                                <input type="hidden" name="imageurl" value="">
                                <div class="col-sm-9">
                                    <div id="uploader-demo">
                                        <!--用来存放item-->
                                        <div id="fileList_imageurl" class="uploader-list">

                                        </div>
                                        <div id="filePicker_imageurl">选择图片</div>
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

                                var uploader_imageurl = WebUploader.create({
                                    // 选完文件后，是否自动上传。
                                    auto: true,

                                    // swf文件路径
                                    swf: '{{asset('webuploader/Uploader.swf')}}',

                                    // 文件接收服务端。
                                    server: '{{route('image_upload')}}',

                                    // 选择文件的按钮。可选。
                                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                                    pick: '#filePicker_imageurl',

                                    // 只允许选择图片文件。
                                    accept: {
                                        title: 'Images',
                                        extensions: 'jpg,jpeg,png',
                                        mimeTypes: 'image/*'
                                    }
                                });
                                // 文件上传过程中创建进度条实时显示。
                                uploader_imageurl.on( 'uploadProgress', function( file, percentage ) {
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
                                uploader_imageurl.on( 'uploadSuccess', function( file, response ) {
//        $( '#'+file.id ).addClass('upload-state-done');
                                    $( '#'+file.id ).remove();
                                    uploader_imageurl.reset();
                                    if(response.status == 1){
                                        $("input[name=imageurl]").val(response.data);
                                        $("#fileList_imageurl").html("<img style='width: 110px;' src='"+response.data+"' >");
//            $().appendTo();
                                        $("#upload-tips1").remove();
                                    }else{
                                        alert(response.message);
                                    }
                                });

                                // 文件上传失败，显示上传出错。
                                uploader_imageurl.on( 'uploadError', function( file ) {
                                    var $li = $( '#'+file.id ),
                                            $error = $li.find('div.error');

                                    // 避免重复创建
                                    if ( !$error.length ) {
                                        $error = $('<div class="error"></div>').appendTo( $li );
                                    }

                                    $error.text('上传失败');
                                });

                                // 完成上传完了，成功或者失败，先删除进度条。
                                uploader_imageurl.on( 'uploadComplete', function( file ) {
                                    $( '#'+file.id ).find('.progress').remove();
                                });
                            </script>

                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">内容：</label>
                                <div class="col-sm-9" style="height: 800px">
                                    <!-- 实例化编辑器 -->
                                    <script type="text/javascript">
                                        var ue = UE.getEditor('container',{initialFrameHeight:500});
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



    <!-- 自定义js -->
    <script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
    <script src="{{asset('admin/js/jquery.form.js')}}"></script>
    {{--jqueryUI--}}
    <script src="{{asset('admin/js/jquery-ui-1.10.4.min.js')}}"></script>

    {{--弹出js--}}
    <script src="{{asset('admin/plugins/layer/layer.js')}}"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/messages_zh.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/js/plugins/datetimepicker/jquery.datetimepicker.full.js')}}"></script>

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

            $.datetimepicker.setLocale('ch');
            $("#publish_time").datetimepicker({
                format:'Y-m-d h:i',
                yearStart:2000
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
                    Actionsubmit(form,'POST','{{route("article.index")}}');
                }
            });

        });
    </script>

</body>

</html>
