<div class="form-group" >
    <label class="col-sm-3 control-label">{{$i->name}}：</label>
    <input type="hidden" name="{{$i->r_name}}">
    <div class="col-sm-9">
        <div class="page-container">
            <h1 id="demo">Demo</h1>

            <p>您可以尝试文件拖拽，使用QQ截屏工具，然后激活窗口后粘贴，或者点击添加图片按钮，来体验此demo.</p>

            <div id="uploader_{{$i->r_name}}" class="wu-example">
                <div class="queueList">
                    <div id="dndArea" class="placeholder">
                        <div id="filePicker" class="webuploader-container">
                            <div class="webuploader-pick">点击选择图片</div>
                        </div>
                    </div>
                        <p>或将照片拖到这里，单次最多可选300张</p>
                    </div>
                    <ul class="filelist"></ul></div>
                <div class="statusBar" style="display:none;">
                    <div class="progress" style="display: none;">
                        <span class="text">0%</span>
                        <span class="percentage" style="width: 0%;"></span>
                    </div><div class="info">共0张（0B），已上传0张</div>
                    <div class="btns">
                        <div id="filePicker2" class="webuploader-container"><div class="webuploader-pick">继续添加</div><div id="rt_rt_1cimaa9mq1n021lkm1kjq1nbqk7p6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div><div class="uploadBtn state-pedding">开始上传</div>
                    </div>
                </div>
            </div>

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

    var uploader_{{$i->r_name}} = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '{{asset('webuploader/Uploader.swf')}}',

        // 文件接收服务端。
        server: '{{route('image_upload')}}',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker_{{$i->r_name}}',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    // 文件上传过程中创建进度条实时显示。
    uploader_{{$i->r_name}}.on( 'uploadProgress', function( file, percentage ) {
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
    uploader_{{$i->r_name}}.on( 'uploadSuccess', function( file, response ) {
//        $( '#'+file.id ).addClass('upload-state-done');
        $( '#'+file.id ).remove();
        uploader_{{$i->r_name}}.reset();
        if(response.status == 1){
            $("input[name={{$i->r_name}}]").val(response.data);
            $("#fileList_{{$i->r_name}}").html("<img style='width: 100%;' src='"+response.data+"' >");
//            $().appendTo();
            $("#upload-tips1").remove();
        }else{
            alert(response.message);
        }
    });

    // 文件上传失败，显示上传出错。
    uploader_{{$i->r_name}}.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader_{{$i->r_name}}.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
</script>