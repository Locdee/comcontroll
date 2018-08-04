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
                    <strong>编辑</strong>
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
                    <form id="signupForm" method="post" action="{{route('wechat_menu.update',['id'=>$menu->id])}}" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">名称：</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" name="name"  class="form-control" placeholder="请输入名称" value="{{$menu->name}}">
                                <span class="help-block m-b-none">菜单栏名称</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">回复消息类型：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type">
                                    @foreach($menu_type_arr as $type)
                                        @if($type['disable']==1)
                                        <option value="{{$type['type']}}" {{$menu->type==$type['type']?'selected':''}}>{{$type['text']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">显示顺序：</label>
                            <div class="col-sm-9">
                                <input id="listindex" type="number" name="listindex"  class="form-control" placeholder="显示顺序" value="{{$menu->listindex}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">所在公众号：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="official_account_id" data-id="{{$menu->id}}">
                                    @foreach($official_list as $o)
                                        <option value="{{$o->id}}" {{ $menu->official_account_id==$o->id?'selected':'' }}>{{$o->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">父级菜单栏：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="pid" >
                                    <option value="0">一级菜单栏</option>
                                    @foreach($parent_menu_list as $p)
                                        <option value="{{$p->id}}" {{$menu->pid==$p->id?'selected':''}}>{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态：</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status">
                                    @foreach($status_arr as $k=>$status)
                                        <option value="{{ $k }}" {{$menu->status==$k?'selected':''}}>{{ $status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group click reply" >
                            <label class="col-sm-3 control-label">click_key值：</label>
                            <div class="col-sm-9">
                                <input id="click_key" type="text" name="click_key"  class="form-control" placeholder="请输入关键词" value="{{$menu->click_key}}">
                                <span class="help-block m-b-none">点击key值(和微信自动回复中的click_key结合使用)</span>
                            </div>
                        </div>




                            <div class="form-group miniprogram reply" >
                                <label class="col-sm-3 control-label">appid：</label>
                                <div class="col-sm-9">
                                    <input id="appid" type="text" name="appid"  class="form-control" placeholder="小程序appid" value="{{$menu->appid}}">
                                    <span class="help-block m-b-none">小程序appid</span>
                                </div>
                            </div>
                            <div class="form-group view miniprogram reply" >
                                <label class="col-sm-3 control-label">跳转网页(小程序)链接：</label>
                                <div class="col-sm-9">
                                    <input id="url" type="text" name="url"  class="form-control" placeholder="请填写链接地址" value="{{$menu->url}}">
                                    <span class="help-block m-b-none">跳转网页(小程序)链接地址</span>
                                </div>
                            </div>
                            <div class="form-group miniprogram reply" >
                                <label class="col-sm-3 control-label">小程序路径：</label>
                                <div class="col-sm-9">
                                    <input id="pagepath" type="text" name="pagepath"  class="form-control" placeholder="路径" value="{{$menu->pagepath}}">
                                    <span class="help-block m-b-none">小程序路径</span>
                                </div>
                            </div>

                            <div class="form-group media_id reply" >
                                <label class="col-sm-3 control-label">图片上传：</label>
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
                var t = $('select[name=type]').val();
                $('.reply').hide();
                switch(t){
                    case 'click':
                        $('.click').show();
                        break;
                    case 'view':
                        $('.view').show();
                        break;

                    case 'media_id':
                        $('.media_id').show();
                        break;
                    case 'miniprogram':
                        $('.miniprogram').show();
                        break;


                    default:
                        break;
                }
            }
            setTimeout(reply_change,500);
            $('select[name=type]').change(function(){
//                return;
                var t = $(this).val();
                $('.reply').hide();
                switch(t){
                    case 'click':
                        $('.click').show();
                        break;
                    case 'view':
                        $('.view').show();
                        break;

                    case 'media_id':
                        $('.media_id').show();
                        break;
                    case 'miniprogram':
                        $('.miniprogram').show();
                        break;

                    default:
                        break;
                }
            });
            $('select[name=official_account_id]').change(function(){
                var account_id = $(this).val();
                var i = $(this).data('id');
                $.ajax({
                    type:'GET',
                    url:'{{route('get_parent_menu')}}',
                    data:{official_account_id:account_id,id:i},
                    dataType:'json',
                    success:function(res){
                        if(res.status==1){
                            var oft = '<option value="0">一级菜单栏</option>';
                            $(res.data).each(function(index,element){
                                oft+=`<option value="${element.id}">${element.name}</option>`;
                            });
                            $('select[name=pid]').html(oft);
                        }
                    }
                })
            });
            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    node_id: "required"
                },
                messages: {
                    name: icon + "请输如菜单栏名称",
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
