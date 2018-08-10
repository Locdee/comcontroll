<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>主页</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">Beaut-zihan</strong></span>
                                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                                </li>
                                <li><a class="J_menuItem" href="profile.html">个人资料</a>
                                </li>
                                <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                                </li>
                                <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="{{ route('admin.logout') }}">安全退出</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">H+
                        </div>
                    </li>
                    <li>
                        <a class="J_menuItem" href="index_v1.html" data-index="1">
                            <i class="fa fa-home"></i>
                            <span class="nav-label">主页</span>
                            <span class="fa arrow"></span>
                        </a>
                    </li>
                    @foreach($menu_tree as $menu)
                        <li>
                            <a class="J_menuItem" href="@if(!count($menu['children']) && (!empty($menu['url']))) {{ route($menu['url']) }} @endif"><i class="fa fa-columns"></i> <span class="nav-label">{{$menu['name']}}</span>
                                @if(count($menu['children']))
                                    <span class="fa arrow"></span>
                                @endif
                            </a>
                            @if(count($menu['children']))
                                <ul class="nav nav-second-level">
                                    @foreach($menu['children'] as $c)
                                        <li>
                                            <a class="J_menuItem" href="{{ route($c['url']) }}"><i class="fa fa-columns"></i> <span class="nav-label">{{$c['name']}}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                            <div class="form-group">
                                {{--<input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">--}}
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">

                        <li class="dropdown hidden-xs">
                            <a class="right-sidebar-toggle" aria-expanded="false">
                                <i class="fa fa-tasks"></i> 主题
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">我的桌面</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabShowActive"><a>定位当前选项卡</a>
                        </li>
                        <li class="divider"></li>
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('admin.logout') }}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ route('admin.main') }}" frameborder="0" data-id="index_v1.html" seamless></iframe>
            </div>
            <div class="footer text-center">
                <div class="">&copy; {{date('Y')-1}}-{{date('Y')}} <a href="javascript:void(0);" target="_blank">杭州网</a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
        <!--右侧边栏开始-->
        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <i class="fa fa-gear"></i> 主题
                        </a>
                    </li>


                </ul>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> 主题设置</h3>
                            <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small>
                        </div>
                        <div class="skin-setttings">
                            <div class="title">主题设置</div>
                            <div class="setings-item">
                                <span>收起左侧菜单</span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                        <label class="onoffswitch-label" for="collapsemenu">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>固定顶部</span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                        <label class="onoffswitch-label" for="fixednavbar">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>
                        固定宽度
                    </span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                        <label class="onoffswitch-label" for="boxedlayout">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="title">皮肤选择</div>
                            <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                            </div>
                            <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                            </div>
                            <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-3">
                            黄色/紫色主题
                        </a>
                    </span>
                            </div>
                        </div>
                    </div>

                    <div id="tab-3" class="tab-pane">

                        {{--<div class="sidebar-title">--}}
                            {{--<h3> <i class="fa fa-cube"></i> 最新任务</h3>--}}
                            {{--<small><i class="fa fa-tim"></i> 您当前有14个任务，10个已完成</small>--}}
                        {{--</div>--}}

                        {{--<ul class="sidebar-list">--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>市场调研</h4> 按要求接收教材；--}}

                                    {{--<div class="small">已完成： 22%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>--}}
                                    {{--</div>--}}
                                    {{--<div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>可行性报告研究报上级批准 </h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对--}}

                                    {{--<div class="small">已完成： 48%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 48%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>立项阶段</h4> 东风商用车公司 采购综合综合查询分析系统项目进度阶段性报告武汉斯迪克科技有限公司--}}

                                    {{--<div class="small">已完成： 14%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 14%;" class="progress-bar progress-bar-info"></div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<span class="label label-primary pull-right">NEW</span>--}}
                                    {{--<h4>设计阶段</h4>--}}
                                    {{--<!--<div class="small pull-right m-t-xs">9小时以后</div>-->--}}
                                    {{--项目进度报告(Project Progress Report)--}}
                                    {{--<div class="small">已完成： 22%</div>--}}
                                    {{--<div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>拆迁阶段</h4> 科研项目研究进展报告 项目编号: 项目名称: 项目负责人:--}}

                                    {{--<div class="small">已完成： 22%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>--}}
                                    {{--</div>--}}
                                    {{--<div class="small text-muted m-t-xs">项目截止： 4:00 - 2015.10.01</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>建设阶段 </h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对--}}

                                    {{--<div class="small">已完成： 48%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 48%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<div class="small pull-right m-t-xs">9小时以后</div>--}}
                                    {{--<h4>获证开盘</h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的 开发进度作出一个合理的比对--}}

                                    {{--<div class="small">已完成： 14%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 14%;" class="progress-bar progress-bar-info"></div>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}

                        {{--</ul>--}}

                    </div>
                </div>

            </div>
        </div>
        <!--右侧边栏结束-->
    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
    <script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/layer/layer.min.js') }}"></script>

    <!-- 自定义js -->
    <script src="{{ asset('admin/js/hplus.js?v=4.1.0') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/contabs.js') }}"></script>

    <!-- 第三方插件 -->
    <script src="{{ asset('admin/js/plugins/pace/pace.min.js') }}"></script>

</body>

</html>
