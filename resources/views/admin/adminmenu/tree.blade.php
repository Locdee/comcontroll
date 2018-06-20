<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>菜单栏</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/treeview/bootstrap-treeview.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="row wrapper wrapper-content animated fadeInRight">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>后台菜单栏显示</h5>
                </div>
                <div class="ibox-content">
                    <p>菜单栏修改会影响后台功能，请谨慎操作。<br/>
                        <a class="btn btn-w-m btn-success" href="{{route('menu.create')}}">增加菜单栏</a>
                    </p>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-sm-offset-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>菜单栏树形图</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="treeview" class="test">
                        <ul class="list-group">
                            @foreach($menu_tree as $menu)
                            <li class="list-group-item" >
                                <span class="icon">
                                    {{$menu->name}}
                                </span>
                                <span class="badge">
                                    <a class=" btn-outline btn-danger btn-delete" data-url="{{ route('menu.destroy',['id'=>$menu->id]) }}">删除</a>
                                </span>
                                <span class="badge">
                                    <a class=" btn-outline btn-primary" href="{{ route('menu.edit',['id'=>$menu->id]) }}">编辑</a>
                                </span>

                                @if($menu->children()->count())
                                    <ul class="list-group">
                                        @foreach($menu->children as $child)
                                            <li class="list-group-item" >
                                                <span class="icon">
                                                    {{$child->name}}
                                                </span>
                                                <span class="badge">
                                                    <a class=" btn-outline btn-danger btn-delete" data-url="{{ route('menu.destroy',['id'=>$child->id]) }}">删除</a>
                                                </span>
                                                <span class="badge">
                                                    <a class=" btn-outline btn-primary" href="{{ route('menu.edit',['id'=>$child->id]) }}">编辑</a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>







    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    <!-- 自定义js -->
    <script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>

    {{--弹出js--}}
    <script src="{{asset('admin/plugins/layer/layer.js')}}"></script>

    <!-- Bootstrap-Treeview plugin javascript -->
    <script src="{{asset('admin/js/plugins/treeview/bootstrap-treeview.js')}}"></script>
    <script type="text/javascript">
        $(function () {

            var defaultData = [

                    @foreach($menu_tree as $menu)
                        {
                            text: '{{$menu->name}}',
                            selectable:true,
                            state: {
                                disable:true
                            },
                            tags:['<a class=" btn-outline btn-danger btn-delete" data-url="{{route('menu.destroy',['id'=>$menu->id])}}">删除</a>','<a class=" btn-outline btn-primary" href="{{route('menu.edit',['id'=>$menu->id])}}">编辑</a>',],
                            @if($menu->children()->count())
                            nodes: [
                                    @foreach($menu->children as $child)
                                        {
                                            text:'{{$child->name}}',
                                            state: {
                                                disable:true
                                            },
                                            tags:['<a class=" btn-outline btn-danger btn-delete" data-url="{{route('menu.destroy',['id'=>$child->id])}}">删除</a>','<a class=" btn-outline btn-primary" href="{{route('menu.edit',['id'=>$child->id])}}">编辑</a>',],
                                        },
                                    @endforeach
                            ]
                            @endif
                        },
                    @endforeach
            ];

//            $('#treeview').treeview({
//                color: "#428bca",
//                expandIcon: 'glyphicon glyphicon-chevron-right',
//                collapseIcon: 'glyphicon glyphicon-chevron-down',
//                nodeIcon: 'glyphicon glyphicon-bookmark',
//                showTags:true,
////                enableLinks:true,
//                data: defaultData,
//                onNodeSelected:function(event,data){
//                    alert(event);
//                    alert(data.tags);
//                },
//                onNodeChecked :function(event,data){
//                    alert(3);
//                }
//            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
