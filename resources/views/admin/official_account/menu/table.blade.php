 <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>公众号账号菜单栏管理</title>
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
                            <div class="col-sm-9">
                                <a class="btn btn-w-m btn-success" href="{{route('wechat_menu.create')}}">增加菜单栏</a>
                            </div>
                            <div class="col-sm-3 right">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入关键词" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>

                                        <th><input type="checkbox" class="i-checks" name="input[]">全选</th>
                                        <th>名称</th>
                                        <th>所在公众号</th>
                                        <th>显示顺序</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menu_list as $i)
                                    <tr>
                                        <td>
                                            <input type="checkbox"  class="i-checks" name="input[]">
                                        </td>
                                        <td>{{ $i->name }}</td>
                                        <td>
                                            {{ $i->official_account->name }}
                                        </td>
                                        <td>
                                            {{ $i->listindex }}
                                        </td>

                                        <td>
                                            <a href="{{route('wechat_menu.edit',['id'=>$i->id])}}" class="btn btn-info " type="button"><i class="fa fa-paste"></i> 编辑</a>
                                            <button class="btn btn-warning btn-delete " type="button" data-url="{{ route('wechat_menu.destroy',['id'=>$i->id]) }}"><i class="fa fa-times"></i> <span class="bold">删除</span>
                                            </button>

                                            <button data-id="{{$i->id}}" class="btn btn-info show_children" type="button"><i class="fa fa-plus-square-o"></i> 显示子菜单</button>
                                            <button data-id="{{$i->id}}" class="btn btn-default hidden_children" type="button"><i class="fa fa-minus-square-o"></i> 隐藏子菜单</button>
                                        </td>

                                    </tr>
                                        @foreach($i->children as $child)
                                            <tr class="children-{{$i->id}} children" style="background-color: lightgrey">
                                                <td>
                                                    <input type="checkbox"  class="i-checks" name="input[]">
                                                </td>
                                                <td>&nbsp;|-{{ $child->name }}</td>
                                                <td>
                                                    {{ $child->official_account->name }}
                                                </td>
                                                <td>
                                                    {{ $child->listindex }}
                                                </td>

                                                <td>
                                                    <a href="{{route('wechat_menu.edit',['id'=>$child->id])}}" class="btn btn-info " type="button"><i class="fa fa-paste"></i> 编辑</a>
                                                    <button class="btn btn-warning btn-delete " type="button" data-url="{{ route('wechat_menu.destroy',['id'=>$child->id]) }}"><i class="fa fa-times"></i> <span class="bold">删除</span></button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
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
//            $('.children').hide();
//            $('.hidden_children').hide();

            //显示子菜单
            $('.show_children').click(function(){
                var id = $(this).data('id');
                $('.children-'+id).show();
                $(this).hide();
                $(this).siblings('.hidden_children').show();
            });
            $('.hidden_children').click(function(){
                var id = $(this).data('id');
                $('.children-'+id).hide();
                $(this).hide();
                $(this).siblings('.show_children').show();
            }).trigger('click');
        });
    </script>

</body>

</html>
