 <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>专题管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">

                        {{--<div class="ibox-tools">--}}
                            {{--<a class="collapse-link">--}}
                                {{--<i class="fa fa-chevron-up"></i>--}}
                            {{--</a>--}}
                            {{--<a class="dropdown-toggle" data-toggle="dropdown" href="table_basic.html#">--}}
                                {{--<i class="fa fa-wrench"></i>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu dropdown-user">--}}
                                {{--<li><a href="table_basic.html#">选项1</a>--}}
                                {{--</li>--}}
                                {{--<li><a href="table_basic.html#">选项2</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                            {{--<a class="close-link">--}}
                                {{--<i class="fa fa-times"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-2">
                                <a class="btn btn-w-m btn-success" href="{{route('activity.create')}}">增加专题</a>
                            </div>
                            <form>
                            <div class="col-sm-10 right">
                                <div class="input-group">
                                    <div class="col-sm-4 right">
                                        <input name="keyword" value="{{$keyword}}" type="text" placeholder="请输入关键词" class="form-control">
                                    </div>
                                    <div class="col-sm-4 right">

                                        <select name="type" class="form-control ">
                                            <option value="">所有类型</option>
                                            @foreach($type_arr as $key=>$t)
                                                <option value="{{$key}}" {{$type==$key?'selected':''}}>{{$t}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-sm-4 right">

                                        <select name="official_account_id" class="form-control ">
                                            <option value="">相关公众号</option>
                                            @foreach($official_list as $official)
                                                <option value="{{$official->id}}" {{$official_account_id==$official->id?'selected':''}}>{{$official->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="table-responsive" style="overflow-x:unset">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>

                                        <th><input type="checkbox" class="i-checks" name="input[]">全选</th>
                                        <th>专题名称</th>
                                        <th>专题类型</th>
                                        <th>相关公众号</th>
                                        <th>状态</th>
                                        <th>查看</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activity_list as $i)
                                    <tr>
                                        <td>
                                            <input type="checkbox"  class="i-checks" name="input[]">
                                        </td>
                                        <td>{{ $i->activityname }}</td>
                                        <td>
                                            @if($i->is_register==1)
                                                <button type="button" class="btn  btn-primary">信息采集</button>&nbsp;
                                            @endif
                                            @if($i->is_vote==1)
                                                <button type="button" class="btn  btn-success">投票</button>&nbsp;
                                            @endif
                                                @if($i->is_lottery==1)
                                                    <button type="button" class="btn btn-info">抽奖</button>&nbsp;
                                                @endif

                                                @if($i->is_questionnaire==1)
                                                    <button type="button" class="btn btn-primary">答题</button>&nbsp;
                                                @endif
                                        </td>

                                        <td>{{ $i->official->name}}</td>
                                        <td>
                                            @if($i->status==1)
                                                <button type="button" class="btn btn-w-m btn-success btn-status"  data-url="{{route('activity.status',['id'=>$i->id])}}" data-status="2">进行中</button>
                                            @else($i->status==2)
                                                <button type="button" class="btn btn-w-m btn-default btn-status"  data-url="{{route('activity.status',['id'=>$i->id])}}" data-status="1">已关闭</button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">查看 <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($i->is_register==1)
                                                    <li>
                                                        <a href="{{route('register_activity.index',['activity_id'=>$i->id])}}" data-id="{{route('register_activity.index')}}">信息采集(活动报名)表</a>
                                                    </li>
                                                        <li class="divider"></li>
                                                    @endif

                                                    @if($i->is_vote==1)
                                                        <li>
                                                            <a href="{{route('vote_team.index',['activity_id'=>$i->id])}}" data-id="{{route('vote_team.index')}}">投票队伍</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                    @endif

                                                    @if($i->is_lottery==1)
                                                        <li><a href="{{route('prize.index',['activity_id'=>$i->id])}}" data-id="{{route('prize.index')}}">奖品管理</a>
                                                        </li>
                                                        <li><a href="{{route('lottery_log.index',['activity_id'=>$i->id])}}" data-id="{{route('lottery_log.index')}}">抽奖记录</a>
                                                        </li>
                                                            <li class="divider"></li>
                                                    @endif

                                                    @if($i->is_questionnaire==1)
                                                        <li><a href="{{route('questionnaire.index',['activity_id'=>$i->id])}}" data-id="{{route('questionnaire.index')}}">相关题目</a>
                                                        </li>
                                                        {{--<li><a href="buttons.html#">答题记录</a>--}}
                                                        {{--</li>--}}
                                                            <li class="divider"></li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('activity.edit',['id'=>$i->id])}}" class="btn btn-info " type="button"><i class="fa fa-paste"></i> 编辑</a>
                                            <button class="btn btn-warning btn-delete " type="button" data-url="{{ route('activity.destroy',['id'=>$i->id]) }}"><i class="fa fa-times"></i> <span class="bold">删除</span>
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$activity_list->appends(['official_account_id'=>$official_account_id,'keyword'=>$keyword,'type'=>$type])->links()}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>



    <!-- Peity -->
    <script src="{{asset('admin/js/plugins/peity/jquery.peity.min.js')}}"></script>

    <!-- 自定义js -->
    <script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>


    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('admin/js/demo/peity-demo.js')}}"></script>
    <!-- 弹窗 -->
    <script src="{{asset('admin/plugins/layer/layer.js')}}"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            //跳转到父级窗口
            $('.dropdown-menu').on('click','a',function(event){
                event.preventDefault();
                var dataUrl = $(this).data('id');
                var src = $(this).attr('href');
                var menuName = '';
                var dataIndex = 0;
                var flag = true;
//                alert(menuName);
                $('.J_menuItem',parent.document).each(function(){
//                    alert($(this).data('id'));
                    if ($(this).attr('href') == dataUrl){
                        dataIndex = $(this).data('index');
                        menuName = $.trim($(this).text());
//                        alert(menuName);
                    }
                });
//                alert(menuName);

                $('.J_menuTabs',parent.document).each(function(){

                    if (dataUrl == undefined || $.trim(dataUrl).length == 0)return false;

                    // 选项卡菜单已存在
                    $('.J_menuTab',parent.document).each(function () {
                        if ($(this).data('id') == dataUrl) {
                            if (!$(this).hasClass('active')) {
                                $(this).addClass('active').siblings('.J_menuTab').removeClass('active');
                                window.parent.window.scrollToTab($('.J_menuTab.active',parent.document));
                                // 显示tab对应的内容区
                                $('.J_mainContent .J_iframe',parent.document).each(function () {
                                    if ($(this).data('id') == dataUrl) {
//                                        var src = $(this).attr('src');
                                        $(this).attr('src',src);
                                        $(this).show().siblings('.J_iframe').hide();
                                        return false;
                                    }
                                });
                            }
                            flag = false;
                            return false;
                        }
                    });

                    // 选项卡菜单不存在
                    if (flag) {
                        var str = '<a href="javascript:;" class="active J_menuTab" data-id="' + dataUrl + '">' + menuName + ' <i class="fa fa-times-circle"></i></a>';
                        $('.J_menuTab',parent.document).removeClass('active');

                        // 添加选项卡对应的iframe
                        var str1 = '<iframe class="J_iframe" name="iframe' + dataIndex + '" width="100%" height="100%" src="' + src + '" frameborder="0" data-id="' + dataUrl + '" seamless></iframe>';
                        $('.J_mainContent',parent.document).find('iframe.J_iframe').hide().parents('.J_mainContent').append(str1);

                        //显示loading提示
//            var loading = layer.load();
//
//            $('.J_mainContent iframe:visible').load(function () {
//                //iframe加载完成后隐藏loading提示
//                layer.close(loading);
//            });
                        // 添加选项卡
                        $('.J_menuTabs .page-tabs-content',parent.document).append(str);
                        window.parent.window.scrollToTab($('.J_menuTab.active',parent.document));
                    }
                    return false;
                });
            });


            //修改状态
            $('.btn-status').click(function(){
                var url = $(this).data('url');
                var s =$(this).data('status');
                layer.confirm('确认修改该专题状态吗？', {
                    title:'提示框',
                    btn: ['确定', '取消'], //可以无限个按钮
                    yes:function(){
                        $.ajax({
                            type:'PUT',
                            dataType:'json',
                            url:url,
                            data:{status:s},
                            success:function(res){
                                if(res.status=='1'){
                                    layer.msg(res.message);
                                    setTimeout('location.reload();',1000);
                                }else{
                                    layer.msg(res.message);
                                }
                            }

                        })
                    }

                });
            });
            //删除弹窗事件
            $('.btn-delete').click(function(){
                var url = $(this).data('url');
                layer.confirm('确认删除吗？', {
                    title:'提示框',
                    btn: ['确定', '取消'], //可以无限个按钮
                    yes:function(){
                        $.ajax({
                            type:'DELETE',
                            dataType:'json',
                            url:url,
                            success:function(res){
                                if(res.status=='1'){
                                    layer.msg(res.message);
                                    setTimeout('location.reload();',1000);
                                }else{
                                    layer.msg(res.message);
                                }
                            }

                        })
                    }

                });
            });
        });
    </script>

</body>

</html>
