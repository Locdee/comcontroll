<div class="form-group" >
    <label class="col-sm-3 control-label">{{$i->name}}：</label>
    <div id="input_{{$i->r_name}}">

    </div>
    <div class="col-sm-9">
        <div class="page-container">
            <div id="uploader_{{$i->r_name}}" class="wu-example">
                <div class="queueList">
                    <div id="dndArea" class="placeholder">
                        <div id="filePicker_{{$i->r_name}}" class="webuploader-container">
                            <div class="webuploader-pick">点击选择图片</div>
                        </div>
                    </div>
                    <p>或将照片拖到这里，单次最多可选10张</p>
                </div>
                <div class="statusBar" style="display:none;">
                    <div class="progress" style="display: none;">
                        <span class="text">0%</span>
                        <span class="percentage" style="width: 0%;"></span>
                    </div>
                    <div class="info">共0张（0B），已上传0张</div>
                    <div class="btns">
                        <div id="filePicker2_{{$i->r_name}}" class="webuploader-container ">
                            <div class="webuploader-pick">继续添加</div>
                        </div>
                        <div class="uploadBtn state-pedding">开始上传</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">


    //实例
    jQuery(function() {
        var $ = jQuery,

                $wrap_{{$i->r_name}} = $('#uploader_{{$i->r_name}}'),

        // 图片容器
                $queue_{{$i->r_name}} = $('<ul class="filelist"></ul>')
                        .appendTo( $wrap_{{$i->r_name}}.find('.queueList') ),

        // 状态栏，包括进度和控制按钮
                $statusBar_{{$i->r_name}} = $wrap_{{$i->r_name}}.find('.statusBar'),

        // 文件总体选择信息。
                $info_{{$i->r_name}} = $statusBar_{{$i->r_name}}.find('.info'),

        // 上传按钮
                $upload_{{$i->r_name}} = $wrap_{{$i->r_name}}.find('.uploadBtn'),

        // 没选择文件之前的内容。
                $placeHolder_{{$i->r_name}} = $wrap_{{$i->r_name}}.find('.placeholder'),

        // 总体进度条
                $progress_{{$i->r_name}} = $statusBar_{{$i->r_name}}.find('.progress').hide(),

        // 添加的文件数量
                fileCount_{{$i->r_name}} = 0,

        // 添加的文件总大小
                fileSize_{{$i->r_name}} = 0,

        // 优化retina, 在retina下这个值是2
                ratio_{{$i->r_name}} = window.devicePixelRatio || 1,

        // 缩略图大小
                thumbnailWidth = 110 * ratio_{{$i->r_name}},
                thumbnailHeight = 110 * ratio_{{$i->r_name}},

        // 可能有pedding, ready, uploading, confirm, done.
                state = 'pedding',

        // 所有文件的进度信息，key为file id
                percentages = {},

                supportTransition = (function(){
                    var s = document.createElement('p').style,
                            r = 'transition' in s ||
                                    'WebkitTransition' in s ||
                                    'MozTransition' in s ||
                                    'msTransition' in s ||
                                    'OTransition' in s;
                    s = null;
                    return r;
                })(),

        // WebUploader实例
        uploader_{{$i->r_name}};

//        if( !WebUploader.Uploader.support() ){
//            alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
//            throw new Error( 'WebUploader does not support the browser you are using.' );
//        }

        // 实例化
        uploader_{{$i->r_name}} = WebUploader.create({
            pick: {
                id: '#filePicker_{{$i->r_name}}',
                label: '点击选择图片'
            },
            dnd: '#uploader_{{$i->r_name}} .queueList',
            paste: document.body,

            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },

            // swf文件路径
            swf: '{{asset('webuploader/Uploader.swf')}}',

            disableGlobalDnd: true,

            chunked: true,
            // server: 'http://webuploader.duapp.com/server/fileupload.php',
            server: '{{route('image_upload')}}',
            fileNumLimit: 10,
            fileSizeLimit: 50 * 1024 * 1024,    // 200 M
            fileSingleSizeLimit: 10 * 1024 * 1024    // 50 M
        });

        // 添加“添加文件”的按钮，
        uploader_{{$i->r_name}}.addButton({
            id: '#filePicker2_{{$i->r_name}}',
            label: '继续添加'
        });

        // 当有文件添加进来时执行，负责view的创建
        function addFile_{{$i->r_name}}( file ) {
            var $li_{{$i->r_name}} = $( '<li id="' + file.id + '">' +
                            '<p class="title">' + file.name + '</p>' +
                            '<p class="imgWrap"></p>'+
                            '<p class="progress"><span></span></p>' +
                            '</li>' ),

                    $btns = $('<div class="file-panel">' +
                            '<span class="cancel">删除</span>' +
                            '<span class="rotateRight">向右旋转</span>' +
                            '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li_{{$i->r_name}} ),
                    $prgress = $li_{{$i->r_name}}.find('p.progress span'),
                    $wrap_{{$i->r_name}} = $li_{{$i->r_name}}.find( 'p.imgWrap' ),
                    $info_{{$i->r_name}} = $('<p class="error"></p>'),

                    showError = function( code ) {
                        switch( code ) {
                            case 'exceed_size':
                                text = '文件大小超出';
                                break;

                            case 'interrupt':
                                text = '上传暂停';
                                break;

                            default:
                                text = '上传失败，请重试';
                                break;
                        }

                        $info_{{$i->r_name}}.text( text ).appendTo( $li_{{$i->r_name}} );
                    };

            if ( file.getStatus() === 'invalid' ) {
                showError( file.statusText );
            } else {
                // @todo lazyload
                $wrap_{{$i->r_name}}.text( '预览中' );
                uploader_{{$i->r_name}}.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $wrap_{{$i->r_name}}.text( '不能预览' );
                        return;
                    }

                    var img = $('<img src="'+src+'">');
                    $wrap_{{$i->r_name}}.empty().append( img );
                }, thumbnailWidth, thumbnailHeight );

                percentages[ file.id ] = [ file.size, 0 ];
                file.rotation = 0;
            }

            file.on('statuschange', function( cur, prev ) {
                if ( prev === 'progress' ) {
                    $prgress.hide().width(0);
                } else if ( prev === 'queued' ) {
                    $li_{{$i->r_name}}.off( 'mouseenter mouseleave' );
                    $btns.remove();
                }

                // 成功
                if ( cur === 'error' || cur === 'invalid' ) {
                    console.log( file.statusText );
                    showError( file.statusText );
                    percentages[ file.id ][ 1 ] = 1;
                } else if ( cur === 'interrupt' ) {
                    showError( 'interrupt' );
                } else if ( cur === 'queued' ) {
                    percentages[ file.id ][ 1 ] = 0;
                } else if ( cur === 'progress' ) {
                    $info_{{$i->r_name}}.remove();
                    $prgress.css('display', 'block');
                } else if ( cur === 'complete' ) {
                    $li_{{$i->r_name}}.append( '<span class="success"></span>' );
                }

                $li_{{$i->r_name}}.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
            });

            $li_{{$i->r_name}}.on( 'mouseenter', function() {
                $btns.stop().animate({height: 30});
            });

            $li_{{$i->r_name}}.on( 'mouseleave', function() {
                $btns.stop().animate({height: 0});
            });

            $btns.on( 'click', 'span', function() {
                var index = $(this).index(),
                        deg;

                switch ( index ) {
                    case 0:
                        removeFile_{{$i->r_name}}( file );
                        return;

                    case 1:
                        file.rotation += 90;
                        break;

                    case 2:
                        file.rotation -= 90;
                        break;
                }

                if ( supportTransition ) {
                    deg = 'rotate(' + file.rotation + 'deg)';
                    $wrap_{{$i->r_name}}.css({
                        '-webkit-transform': deg,
                        '-mos-transform': deg,
                        '-o-transform': deg,
                        'transform': deg
                    });
                } else {
                    $wrap_{{$i->r_name}}.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                    // use jquery animate to rotation
                    // $({
                    //     rotation: rotation
                    // }).animate({
                    //     rotation: file.rotation
                    // }, {
                    //     easing: 'linear',
                    //     step: function( now ) {
                    //         now = now * Math.PI / 180;

                    //         var cos = Math.cos( now ),
                    //             sin = Math.sin( now );

                    //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                    //     }
                    // });
                }


            });

            $li_{{$i->r_name}}.appendTo( $queue_{{$i->r_name}} );
        }

        // 负责view的销毁
        function removeFile_{{$i->r_name}}( file ) {
            var $li_{{$i->r_name}} = $('#'+file.id);

            delete percentages[ file.id ];
            updateTotalProgress_{{$i->r_name}}();
            $li_{{$i->r_name}}.off().find('.file-panel').off().end().remove();
        }

        function updateTotalProgress_{{$i->r_name}}() {
            var loaded = 0,
                    total = 0,
                    spans = $progress_{{$i->r_name}}.children(),
                    percent;

            $.each( percentages, function( k, v ) {
                total += v[ 0 ];
                loaded += v[ 0 ] * v[ 1 ];
            } );

            percent = total ? loaded / total : 0;

            spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
            spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
            updateStatus_{{$i->r_name}}();
        }

        function updateStatus_{{$i->r_name}}() {
            var text = '', stats;

            if ( state === 'ready' ) {
                text = '选中' + fileCount_{{$i->r_name}} + '张图片，共' +
                        WebUploader.formatSize( fileSize_{{$i->r_name}} ) + '。';
            } else if ( state === 'confirm' ) {
                stats = uploader_{{$i->r_name}}.getStats();
                if ( stats.uploadFailNum ) {
                    text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                            stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                }

            } else {
                stats = uploader_{{$i->r_name}}.getStats();
                text = '共' + fileCount_{{$i->r_name}} + '张（' +
                        WebUploader.formatSize( fileSize_{{$i->r_name}} )  +
                        '），已上传' + stats.successNum + '张';

                if ( stats.uploadFailNum ) {
                    text += '，失败' + stats.uploadFailNum + '张';
                }
            }

            $info_{{$i->r_name}}.html( text );
        }

        function setState_{{$i->r_name}}( val ) {
            var file, stats;

            if ( val === state ) {
                return;
            }

            $upload_{{$i->r_name}}.removeClass( 'state-' + state );
            $upload_{{$i->r_name}}.addClass( 'state-' + val );
            state = val;

            switch ( state ) {
                case 'pedding':
                    $placeHolder_{{$i->r_name}}.removeClass( 'element-invisible' );
                    $queue_{{$i->r_name}}.parent().removeClass('filled');
                    $queue_{{$i->r_name}}.hide();
                    $statusBar_{{$i->r_name}}.addClass( 'element-invisible' );
                    uploader_{{$i->r_name}}.refresh();
                    break;

                case 'ready':
                    $placeHolder_{{$i->r_name}}.addClass( 'element-invisible' );
                    $( '#filePicker2' ).removeClass( 'element-invisible');
                    $queue_{{$i->r_name}}.parent().addClass('filled');
                    $queue_{{$i->r_name}}.show();
                    $statusBar_{{$i->r_name}}.removeClass('element-invisible');
                    uploader_{{$i->r_name}}.refresh();
                    break;

                case 'uploading':
                    $( '#filePicker2' ).addClass( 'element-invisible' );
                    $progress_{{$i->r_name}}.show();
                    $upload_{{$i->r_name}}.text( '暂停上传' );
                    break;

                case 'paused':
                    $progress_{{$i->r_name}}.show();
                    $upload_{{$i->r_name}}.text( '继续上传' );
                    break;

                case 'confirm':
                    $progress_{{$i->r_name}}.hide();
                    $upload_{{$i->r_name}}.text( '开始上传' ).addClass( 'disabled' );

                    stats = uploader_{{$i->r_name}}.getStats();
                    if ( stats.successNum && !stats.uploadFailNum ) {
                        setState_{{$i->r_name}}( 'finish' );
                        return;
                    }
                    break;
                case 'finish':
                    stats = uploader_{{$i->r_name}}.getStats();
                    if ( stats.successNum ) {
                        alert( '上传成功' );
                        $upload_{{$i->r_name}}.removeClass('disabled');
                    } else {
                        // 没有成功的图片，重设
                        state = 'done';
                        location.reload();
                    }
                    break;
            }

            updateStatus_{{$i->r_name}}();
        }

        uploader_{{$i->r_name}}.onUploadProgress = function( file, percentage ) {
            var $li_{{$i->r_name}} = $('#'+file.id),
                    $percent = $li_{{$i->r_name}}.find('.progress span');

            $percent.css( 'width', percentage * 100 + '%' );
            percentages[ file.id ][ 1 ] = percentage;
            updateTotalProgress_{{$i->r_name}}();
        };

        uploader_{{$i->r_name}}.onFileQueued = function( file ) {
            fileCount_{{$i->r_name}}++;
            fileSize_{{$i->r_name}}+= file.size;

            if ( fileCount_{{$i->r_name}} === 1 ) {
                $placeHolder_{{$i->r_name}}.addClass( 'element-invisible' );
                $statusBar_{{$i->r_name}}.show();
            }

            addFile_{{$i->r_name}}( file );
            setState_{{$i->r_name}}( 'ready' );
            updateTotalProgress_{{$i->r_name}}();
        };

        uploader_{{$i->r_name}}.onFileDequeued = function( file ) {
            fileCount_{{$i->r_name}}--;
            fileSize_{{$i->r_name}} -= file.size;

            if ( !fileCount_{{$i->r_name}} ) {
                setState_{{$i->r_name}}( 'pedding' );
            }

            removeFile_{{$i->r_name}}( file );
            updateTotalProgress_{{$i->r_name}}();

        };

        uploader_{{$i->r_name}}.on( 'all', function( type ) {
            var stats;
            switch( type ) {
                case 'uploadFinished':
                    setState_{{$i->r_name}}( 'confirm' );
                    break;

                case 'startUpload':
                    setState_{{$i->r_name}}( 'uploading' );
                    break;

                case 'stopUpload':
                    setState_{{$i->r_name}}( 'paused' );
                    break;

            }
        });

        uploader_{{$i->r_name}}.onError = function( code ) {
            alert( 'Eroor: ' + code );
        };

        $upload_{{$i->r_name}}.on('click', function() {
            if ( $(this).hasClass( 'disabled' ) ) {
                return false;
            }

            if ( state === 'ready' ) {
                uploader_{{$i->r_name}}.upload();
            } else if ( state === 'paused' ) {
                uploader_{{$i->r_name}}.upload();
            } else if ( state === 'uploading' ) {
                uploader_{{$i->r_name}}.stop();
            }
        });

        $info_{{$i->r_name}}.on( 'click', '.retry', function() {
            uploader_{{$i->r_name}}.retry();
        } );

        $info_{{$i->r_name}}.on( 'click', '.ignore', function() {
            alert( 'todo' );
        } );

        $upload_{{$i->r_name}}.addClass( 'state-' + state );
        updateTotalProgress_{{$i->r_name}}();

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader_{{$i->r_name}}.on( 'uploadSuccess', function( file, response ) {
//        $( '#'+file.id ).addClass('upload-state-done');
//            alert(12);

            {{--$( '#'+file.id ).remove();--}}
            {{--uploader_{{$i->r_name}}.reset();--}}
            if(response.status == 1){
                $('<input type="hidden" name="{{$i->r_name}}[]" value='+response.data+'>').appendTo('#input_{{$i->r_name}}')

//            $().appendTo();
//                $("#upload-tips1").remove();
            }else{
                alert(response.message);
            }
        });
    });
</script>