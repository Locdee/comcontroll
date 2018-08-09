 <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>后台反馈管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/chosen/chosen.css')}}" rel="stylesheet">

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
                            <div class="col-sm-6">
                                <a class="btn btn-w-m btn-success" href="{{route('prize.create',['activity_id'=>$ac_id])}}">增加奖品</a>
                            </div>
                            <form>
                                <div class="col-sm-6 right">
                                    <div class="input-group">
                                        <div class="col-sm-6 right">
                                            <input name="keyword" value="{{$keyword}}" type="text" placeholder="请输入关键词" class="form-control">
                                        </div>
                                        <div class="col-sm-6 right">

                                            <select name="activity_id" data-placeholder="选择相关专题..." class="chosen-select" style="width: 100%" tabindex="2">
                                                <option value="">相关专题</option>
                                                @foreach($activity_list as $a)
                                                    <option value="{{$a->id}}" {{ $ac_id==$a->id?'selected':'' }}>{{$a->activityname}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>

                                        <th><input type="checkbox" class="i-checks" name="input[]">全选</th>
                                        <th>奖品</th>
                                        <th>剩余数量</th>
                                        <th>权重</th>
                                        <th>相关专题</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prize_list as $i)
                                    <tr>
                                        <td>
                                            <input type="checkbox"  class="i-checks" name="input[]">
                                        </td>
                                        <td>{{ $i->prizename }}</td>
                                        <td>
                                            {{ $i->count }}
                                        </td>
                                        <td>
                                            {{ $i->weight }}
                                        </td>
                                        <td>{{ $i->activity->activityname}}</td>
                                        <td>
                                            @if($i->status==1)
                                                <button type="button" class="btn btn-w-m btn-success btn-status" data-url="{{route('prize.status',['id'=>$i->id])}}" data-status="2">正常</button>
                                            @else($i->status==2)
                                                <button type="button" class="btn btn-w-m btn-default btn-status" data-url="{{route('prize.status',['id'=>$i->id])}}" data-status="1">已下架</button>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{route('prize.edit',['id'=>$i->id,'activity_id'=>$ac_id])}}" class="btn btn-info " type="button"><i class="fa fa-paste"></i> 编辑</a>
                                            <button class="btn btn-warning btn-delete " type="button" data-url="{{ route('prize.destroy',['id'=>$i->id]) }}"><i class="fa fa-times"></i> <span class="bold">删除</span>
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$prize_list->appends(['keyword'=>$keyword,'activity_id'=>$ac_id])->links()}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>

    <!-- Chosen -->
    <script src="{{asset('admin/js/plugins/chosen/chosen.jquery.js')}}"></script>

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
            //下拉选择
            $('.chosen-select').chosen({
                no_results_text:'没有相关专题',//搜索无结果时显示的提示
                search_contains:true,   //关键字模糊搜索，设置为false，则只从开头开始匹配
            });
            //修改状态
            $('.btn-status').click(function(){
                var url = $(this).data('url');
                var s =$(this).data('status');
                layer.confirm('确认修改该奖品状态吗？', {
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
                layer.confirm('确认删除该奖品吗？', {
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
