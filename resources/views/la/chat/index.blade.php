@extends('la.layouts.app')
@section('htmlheader_title') 在线聊天 @endsection
@section('contentheader_title') 在线交流 @endsection
@section('contentheader_description') Organisation Overview @endsection
@section('main-content')
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-8">
      <!-- DIRECT CHAT -->
      <div class="box box-danger direct-chat direct-chat-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Direct Chat</h3>
          <div class="box-tools pull-right">
            <span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="3 New Messages">3</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
            <i class="fa fa-comments"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="height:500px;">
          <!-- Conversations are loaded here -->
          <div class="direct-chat-messages" style="height:500px;">
            
            <!-- /.direct-chat-msg -->
          </div>
          <!--/.direct-chat-messages-->
          <!-- Contacts are loaded here -->
          <div class="direct-chat-contacts" style="height:500px;">
            <ul class="contacts-list">
              <li>
              
                <a href="#">
                  <img class="contacts-list-img" src="{{asset('/la-assets/img/user4-128x128.jpg')}}" alt="User Image">
                  <div class="contacts-list-info">
                    <span class="contacts-list-name">
                      Count Dracula
                      <small class="contacts-list-date pull-right">2/28/2015</small>
                    </span>
                    <span class="contacts-list-msg">How have you been? I was...</span>
                  </div>
                  <!-- /.contacts-list-info -->
                </a>
              </li>

              <!-- End Contact Item -->
            </ul>
            <!-- /.contatcts-list -->
          </div>
          <!-- /.direct-chat-pane -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="input-group">
            {!!csrf_field()!!}
            <input type="hidden" name="group" value="{{$group}}">
            <input type="hidden" name="user" value="{{$user}}">
              <input type="text" name="message" placeholder="Type Message ..." class="form-control">
              <span class="input-group-btn">
                <button  class="btn btn-danger btn-flat" id="send">Send</button>
              </span>
            </div>
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-4">
      <!-- USERS LIST -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Group Members</h3>
          <div class="box-tools pull-right">
            <span class="label label-danger">{{$count}} Members</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <ul class="users-list clearfix">
            @foreach ($members as $mem)
            <li>
              <img src="{{asset('/la-assets/img/user3-128x128.jpg')}}" alt="User Image">
              <a class="users-list-name" href="#">{{$mem->name}}</a>
              <span class="users-list-date">Today</span>
            </li>
            @endforeach
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Users</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->
  </div>
  </section><!-- /.content -->
  @endsection

  @push('scripts')
  <script type="text/javascript">
    var g_id = $('[name=group]').val();
    var u_id = $('[name=user]').val();
    $('#send').click(function(){
      msg = $('[name=message]').val();
      token = $('[name=_token]').val();
      $.ajax({
        url:"/admin/chat",
        method:"post",
        data:'message='+msg+'&_token='+token+'&user='+u_id+'&group='+g_id,
        success:function(data){
          $('[name=message]').val('');
        }
      });
    });

  </script>

<script type="text/javascript">




function make_msg(data,is_myself=true){
  var obj = data.message;
  if(is_myself){
    float = ' right';
    n_float = 'right';
    t_float = 'left';
  }else{
    float = '';
    n_float = 'left';
    t_float = 'right';
  }
  var msg = '<div class="direct-chat-msg'+float+'"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-'+n_float+'">'+obj.name+'</span><span class="direct-chat-timestamp pull-'+t_float+'">'+obj.created_at+'</span></div><img class="direct-chat-img" src="{{asset("/la-assets/img/user3-128x128.jpg")}}" alt="Message User Image"><div class="direct-chat-text">'+obj.message+'</div></div>';

  $('.direct-chat-messages').append(msg);
}


</script>

  @endpush