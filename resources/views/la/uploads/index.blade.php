@extends("la.layouts.app")

@section("contentheader_title", "上传文件")
@section("contentheader_description", "已上传文件/图片")
@section("section", "上传文件")
@section("sub_section", "Listing")
@section("htmlheader_title", "已上传文件/图片")

@section("headerElems")
@la_access("Uploads", "create")
	<button id="AddNewUploads" class="btn btn-success btn-sm pull-right">添加新文件</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url(config('laraadmin.adminRoute') . '/upload_files') }}" id="fm_dropzone_main" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <a id="closeDZ1"><i class="fa fa-times"></i></a>
    <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>将文件拖拽至此以上传</div>
</form>

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<ul class="files_container">

        </ul>
	</div>
</div>


<section class="content-header">
      <h1>
        时间线
        <small>example</small>
      </h1>
</section>
<?php
/*$usrs=\Illuminate\Foundation\Auth\User::get();

//    dd($usrs);
//    function get_extension($file_name){
//        return substr(strrchr($file_name, '.'), 1);
//    }
foreach ($usrs as $user){
    echo $user['id']."<br/>";
    $img = \App\Models\Upload::where('user_id',$user['id'])
            ->orderBy('id','desc')
            ->first();
        if(!empty($img)){
            echo "用户名：".$user['name'].'<br>'."图片名:".$img->name."<br>"."图片路径".$img->path;
            echo "<br>文件后缀:".$img->extension.'<br>';
            if (file_exists($img->path)) {


   }}}

*/
$flag=0;
?>





{{--下面给的只是一个例子，具体内容需要自己更改--}}
{{--这里的文件上传有问题--}}
<!-- 上传文件时间线 -->
{{--需要用blade模板引擎获取--}}




          @foreach($imgs as $img)
              @foreach($users as $usr)
                  @if($usr['id']==$img['user_id'])
                      {{--找到匹配的文件和对应的路径--}}
                      @if($flag==0)
                      <section class="content">
                      <!-- row -->
                          <div class="row">
                              <div class="col-md-12">
                                  <!-- The time line -->
                                  <ul class="timeline">
                                      @endif
                      @if($img->extension=='jpg')

                          {{--图片时间线样式--}}
                              <li class="time-label">
                                      <span class="bg-red">
                                        {{$img->updated_at}}
                                      </span>
                              </li>
                              <li>
                                  <i class="fa fa-camera bg-purple"></i>

                                  <div class="timeline-item">
                                      <span class="time"><i class="fa fa-clock-o"></i> {{floor((time()-strtotime($img->created_at))/(60*60*24))}} days ago</span>

                                      <h3 class="timeline-header"><a href="#">{{$usr->name}}</a> uploaded new photos</h3>

                                      <div class="timeline-body">
                                          <img src="{{ url('files/'.$img->hash.'/'.$img->name)}}" alt="{{ $img->caption }}" class="margin">
                                      </div>
                                  </div>
                              </li>
                      @endif
                      @if($img->extension=='txt')
                          <!-- END timeline item -->
                              <li>
                                  <i class="fa fa-clock-o bg-gray"></i>
                              </li>
          </ul>
        </div>
          <!-- /.col -->
      </div>
    <!-- /.row -->
<div class="row" style="margin-top: 10px;">
                                  <div class="col-md-12">
                                      <div class="box box-primary">
                                          <div class="box-header">
                                              <h3 class="box-title"><i class="fa fa-code"></i> Timeline Markup</h3>
                                          </div>
                                          <div class="box-body">
                  <pre style="font-weight: 600;">
<?php
if (file_exists($img->path)) {
    // 第三种方式，循环读取，对付大文件
    $fp=fopen($img->path,"r");
    // 我们设置一次读取1024个字节
    $buffer=512;
    $count = 0;
    // 一边读一边判断是否达到文件末尾.end of file
    echo "<hr>";
    $str="";
    while ($count<=1) {
        # code...
        $str.=fread($fp,$buffer);
        $count++;
    }
    $str=str_replace("\r\n","<br>",$str);
    iconv("UTF-8","GB2312//IGNORE",$str);
    echo "$str";
    fclose($fp);
}
?>
                  </pre>
                                          </div>
                                          <!-- /.box-body -->
                                      </div>
                                      <!-- /.box -->
                                  </div>
                                  <!-- /.col -->
                              </div>
<div class="col-md-12">
        <!-- The time line -->
<ul class="timeline">
                      @endif
                  @endif
              @endforeach
          @endforeach
</section>







                {{--**********************************华丽的分割线，下面是妖艳的贱货********************************--}}
    <section class="content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <!-- The time line -->
                <ul class="timeline">
<!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    {{date("Y-m-d H")}}
                  </span>
            </li>
            <!-- /.timeline-label -->


            <!-- timeline item  这是一个邮件-->
            <li>
              <i class="fa fa-envelope bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                <div class="timeline-body">
                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                  weebly ning heekya handango imeem plugg dopplr jibjab, movity
                  jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                  quora plaxo ideeli hulu weebly balihoo...
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">Read more</a>
                  <a class="btn btn-danger btn-xs">Delete</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->


            <!-- timeline item -->
            <li>
              <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
              </div>
            </li>
            <!-- END timeline item -->


            <!-- timeline item -->
            <li>
              <i class="fa fa-comments bg-yellow"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                <div class="timeline-body">
                  Take me to your leader!
                  Switzerland is small and neutral!
                  We are more like Germany, ambitious and misunderstood!
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->


            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-green">
                    3 Jan. 2014
                  </span>
            </li>
            <!-- /.timeline-label -->


            <!-- timeline item -->
            <li>
              <i class="fa fa-camera bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                <div class="timeline-body">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                </div>
              </div>
            </li>
            <!-- END timeline item -->


            <!-- timeline item -->
            <li>
              <i class="fa fa-video-camera bg-maroon"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>

                <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                <div class="timeline-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" frameborder="0" allowfullscreen=""></iframe>
                  </div>
                </div>
                <div class="timeline-footer">
                  <a href="#" class="btn btn-xs bg-maroon">See comments</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-code"></i> Timeline Markup</h3>
            </div>
            <div class="box-body">
                  <pre style="font-weight: 600;">&lt;ul class="timeline"&gt;

    &lt;!-- timeline time label --&gt;
    &lt;li class="time-label"&gt;
        &lt;span class="bg-red"&gt;
            10 Feb. 2014
        &lt;/span&gt;
    &lt;/li&gt;
    &lt;!-- /.timeline-label --&gt;

    &lt;!-- timeline item --&gt;
    &lt;li&gt;
        &lt;!-- timeline icon --&gt;
        &lt;i class="fa fa-envelope bg-blue"&gt;&lt;/i&gt;
        &lt;div class="timeline-item"&gt;
            &lt;span class="time"&gt;&lt;i class="fa fa-clock-o"&gt;&lt;/i&gt; 12:05&lt;/span&gt;

            &lt;h3 class="timeline-header"&gt;&lt;a href="#"&gt;Support Team&lt;/a&gt; ...&lt;/h3&gt;

            &lt;div class="timeline-body"&gt;
                ...
                Content goes here
            &lt;/div&gt;

            &lt;div class="timeline-footer"&gt;
                &lt;a class="btn btn-primary btn-xs"&gt;...&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/li&gt;
    &lt;!-- END timeline item --&gt;

    ...

&lt;/ul&gt;
                  </pre>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    <div style="padding: 10px 0px; text-align: center;"><div class="text-muted">&copy;Powered By Nautilus</div><script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><div class="visible-xs visible-sm"><!-- AdminLTE --><ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-4495360934352473" data-ad-slot="5866534244"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div><div class="hidden-xs hidden-sm"><!-- Home large leaderboard --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4495360934352473" data-ad-slot="1170479443"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div></div></section>

<div class="modal fade" id="EditFileModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:90%;">
		<div class="modal-content">
			<div class="modal-header">
				
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                <!--<button type="button" class="next"><i class="fa fa-chevron-right"></i></button>
                <button type="button" class="prev"><i class="fa fa-chevron-left"></i></button>-->
				<h4 class="modal-title" id="myModalLabel">File: </h4>
			</div>
			<div class="modal-body p0">
                    <div class="row m0">
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="fileObject">
                                
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            {!! Form::open(['class' => 'file-info-form']) !!}
                                <input type="hidden" name="file_id" value="0">
                                <div class="form-group">
                                    <label for="filename">File Name</label>
                                    <input class="form-control" placeholder="File Name" name="filename" type="text" @if(!config('laraadmin.uploads.allow_filename_change') || !Module::hasFieldAccess("Uploads", "name", "write")) readonly @endif value="">
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input class="form-control" placeholder="URL" name="url" type="text" readonly value="">
                                </div>
                                <div class="form-group">
                                    <label for="caption">Label</label>
                                    <input class="form-control" placeholder="Caption" name="caption" type="text" value="" @if(!Module::hasFieldAccess("Uploads", "caption", "write")) readonly @endif>
                                </div>
                                @if(!config('laraadmin.uploads.private_uploads'))
                                    <div class="form-group">
                                        <label for="public">Is Public ?</label>
                                        {{ Form::checkbox("public", "public", false, []) }}
                                        <div class="Switch Ajax Round On" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
                                    </div>
                                @endif
                            {!! Form::close() !!}
                        </div>
                    </div><!--.row-->
			</div>
			<div class="modal-footer">
				<a class="btn btn-success" id="downFileBtn" href="">Download</a>
				@la_access("Uploads", "delete")
                <button type="button" class="btn btn-danger" id="delFileBtn">Delete</button>
				@endla_access
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')
<script>
var bsurl = $('body').attr("bsurl");
var fm_dropzone_main = null;
var cntFiles = null;
$(function () {
	@la_access("Uploads", "create")
	fm_dropzone_main = new Dropzone("#fm_dropzone_main", {
        maxFilesize: 2,
//        指明上传的文件类型
        acceptedFiles: "image/*,application/pdf,.txt,.html",
        init: function() {
            this.on("complete", function(file) {
                this.removeFile(file);
            });
            this.on("success", function(file) {
                console.log("addedfile");
                console.log(file);
                loadUploadedFiles();
            });
        }
    });
    $("#fm_dropzone_main").slideUp();
    $("#AddNewUploads").on("click", function() {
        $("#fm_dropzone_main").slideDown();
    });
    $("#closeDZ1").on("click", function() {
        $("#fm_dropzone_main").slideUp();
    });
	@endla_access
	
    $("body").on("click", "ul.files_container .fm_file_sel", function() {
        var upload = $(this).attr("upload");
        upload = JSON.parse(upload);

        $("#EditFileModal .modal-title").html("File: "+upload.name);
        $(".file-info-form input[name=file_id]").val(upload.id);
        $(".file-info-form input[name=filename]").val(upload.name);
        $(".file-info-form input[name=url]").val(bsurl+'/files/'+upload.hash+'/'+upload.name);
        $(".file-info-form input[name=caption]").val(upload.caption);
        $("#EditFileModal #downFileBtn").attr("href", bsurl+'/files/'+upload.hash+'/'+upload.name+"?download");
        

        @if(!config('laraadmin.uploads.private_uploads'))
        if(upload.public == "1") {
            $(".file-info-form input[name=public]").attr("checked", !0);
            $(".file-info-form input[name=public]").next().removeClass("On").addClass("Off");
        } else {
            $(".file-info-form input[name=public]").attr("checked", !1);
            $(".file-info-form input[name=public]").next().removeClass("Off").addClass("On");
        }
        @endif

        $("#EditFileModal .fileObject").empty();
        if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
            $("#EditFileModal .fileObject").append('<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'">');
            $("#EditFileModal .fileObject").css("padding", "15px 0px");
        } else {
            switch (upload.extension) {
                case "pdf":
                    // TODO: Object PDF
                    $("#EditFileModal .fileObject").append('<object width="100%" height="325" data="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'"></object>');
                    $("#EditFileModal .fileObject").css("padding", "0px");
                    break;
                default:
                    $("#EditFileModal .fileObject").append('<i class="fa fa-file-text-o"></i>');
                    $("#EditFileModal .fileObject").css("padding", "15px 0px");
                    break;
            }
        }
        $("#EditFileModal").modal('show');
    });
    @if(!config('laraadmin.uploads.private_uploads') && Module::hasFieldAccess("Uploads", "public", "write"))
    $('#EditFileModal .Switch.Ajax').click(function() {
        $.ajax({
            url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_public') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);

                loadUploadedFiles();
//                windows.location.reload();
            }

        });
        
    });
    @endif
	
	@la_field_access("Uploads", "caption", "write")
    $(".file-info-form input[name=caption]").on("blur", function() {
        // TODO: Update Caption
        $.ajax({
            url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_caption') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);
                loadUploadedFiles();
            }
        });
    });
	@endla_field_access
	
    @if(config('laraadmin.uploads.allow_filename_change') && Module::hasFieldAccess("Uploads", "name", "write"))
    $(".file-info-form input[name=filename]").on("blur", function() {
        // TODO: Change Filename
        $.ajax({
            url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_filename') }}",
            method: 'POST',
            data: $("form.file-info-form").serialize(),
            success: function( data ) {
                console.log(data);
                loadUploadedFiles();
            }
        });
    });
    @endif

	@la_access("Uploads", "delete")
    $("#EditFileModal #delFileBtn").on("click", function() {
        if(confirm("Delete image "+$(".file-info-form input[name=filename]").val()+" ?")) {
            $.ajax({
                url: "{{ url(config('laraadmin.adminRoute') . '/uploads_delete_file') }}",
                method: 'POST',
                data: $("form.file-info-form").serialize(),
                success: function( data ) {
                    console.log(data);
                    loadUploadedFiles();
                    $("#EditFileModal").modal('hide');
                    window.location.reload();
                }
            });
        }
    });
	@endla_access
	
    loadUploadedFiles();
});
function loadUploadedFiles() {
    // load folder files
    $.ajax({
        dataType: 'json',
        url: "{{ url(config('laraadmin.adminRoute') . '/uploaded_files') }}",
        success: function ( json ) {
            console.log(json);
            cntFiles = json.uploads;
            $("ul.files_container").empty();
            if(cntFiles.length) {
                for (var index = 0; index < cntFiles.length; index++) {
                    var element = cntFiles[index];
                    var li = formatFile(element);
                    $("ul.files_container").append(li);
                }
            } else {
                $("ul.files_container").html("<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>");
            }
        }
    });
}
function formatFile(upload) {
    var image = '';
    if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
        image = '<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'?s=130">';
    } else {
        switch (upload.extension) {
            case "pdf":
                image = '<i class="fa fa-file-pdf-o"></i>';
                break;
            default:
                image = '<i class="fa fa-file-text-o"></i>';
                break;
        }
    }
    return '<li><a class="fm_file_sel" data-toggle="tooltip" data-placement="top" title="'+upload.name+'" upload=\''+JSON.stringify(upload)+'\'>'+image+'</a></li>';
}
</script>
@endpush