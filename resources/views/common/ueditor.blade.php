<div class="col-md-12">

    <div class="form-group">
        <label class="col-sm-3 control-label">相关描述：</label>
        <div class="col-sm-9" style="height: 800px">
            <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container_{{$i->r_name}}',{initialFrameHeight:500});
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                });
            </script>

            <!-- 编辑器容器 -->
            <script id="container_{{$i->r_name}}" name="{{$i->r_name}}" type="text/plain">@if(!empty($register->content[$i->r_name])){!! $register->content[$i->r_name] !!}}@endif</script>

        </div>
    </div>
</div>