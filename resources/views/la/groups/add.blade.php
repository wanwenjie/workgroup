@extends('la.layouts.app')
@section('htmlheader_title') 群组 @endsection
@section('contentheader_title') 群组 @endsection
@section('contentheader_description') Group @endsection
@section('main-content')
<div class="nav-tabs-custom">
<<<<<<< HEAD
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">创建群组</a></li>
              <li><a href="#tab_2" data-toggle="tab">添加成员</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">群名称</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" placeholder="请输入名称">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputfile" class="col-sm-2 control-label">群组图片</label>
                      <div class="col-sm-10">
                        <input type="file" id="exampleInputFile">
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-default">取消</button>
                    <button type="submit" class="btn btn-info pull-right">下一步</button>
                  </div>
                  <!-- /.box-footer -->
              </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_2">
                <form action="/groups/searchEmployees" method="post" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="tab-pane active" id="tab_1">
                <div class="container">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="搜索群成员"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat">邀请</button>
                  </span>
                  </div>
                </div>
              </div>
              </form>
                @if(isset($employees))
                  @for($i=0;$i<count($employees);$i++)
                    <div class="box box-widget widget-user-2">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-yellow">
                        <div class="widget-user-image">
                          <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">{{$employees[$i]->name}}  </h3>
                        <h5 class="widget-user-desc">有理想有抱负的热血青年</h5>
                        <button type="button" class="btn bg-olive btn-flat">申请加入</button>
                      </div>
                    </div>
                  @endfor

                <!-- 找不到 -->
                  @if(count($employees)==0)
                    <div class="box-body">
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> sorry！</h4>
                        我们没有找到你需要的人
                      </div>
                    </div>
                  @endif
                @endif
            </div>


            <!-- /.tab-content -->
          </div>

@endsection
=======
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">创建群组</a></li>
    <li><a href="#tab_2" data-toggle="tab">添加成员</a></li>
    <li><a href="#tab_3" data-toggle="tab">搜索群组</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1">
      
      {!! Form::open(['action' => 'LA\GroupsController@store', 'id' => 'group-add-form']) !!}
      
      <div class="box-body">
        @la_form($module)
        
        {{--
        @la_input($module, 'name')
        @la_input($module, 'path')
        @la_input($module, 'pic')
        --}}
      </div>
      <div class="box-footer">
        {!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
      </div>
      {!! Form::close() !!}
    </div>
    
    <!-- /.tab-content -->


<!-- /.tab-pane -->
<div class="tab-pane" id="tab_2">
  <div class="row" style="width:35%;margin:0 auto;">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="搜索群成员"/>
      <span class="input-group-btn">
        <button type='submit' name='search' id='search-btn' class="btn btn-flat">邀请加入</button>
      </span>
    </div>
    <div class="box-footer">显示内容</div>
  </div>
</div>


<div class="tab-pane" id="tab_3">
  <div class="row" style="width:35%;margin:0 auto;">
>>>>>>> 00470bd13a3bedc4d46001d91b28d7d3ec90805a

    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="搜索群组"/>
      <span class="input-group-btn">
        <button type='submit' name='search' id='search-btn' class="btn btn-flat">申请加入</button>
      </span>
    </div>
    <div class="box-footer">显示内容</div>
    <!-- 找的到就显示信息 -->
    <div class="box box-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-yellow">
        <div class="widget-user-image">
          <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username">鹦鹉螺团队</h3>
        <h5 class="widget-user-desc">有理想有抱负的热血青年</h5>
        <button type="button" class="btn bg-olive btn-flat">申请加入</button>
      </div>

      <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
          <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
          <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
          <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
          <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
        </ul>
      </div>

    </div>
    <!-- 找不到 -->
    <div class="box-body">
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> sorry！</h4>
        我们没有找到你需要的群组
      </div>
    </div>

  </div>
</div>

<<<<<<< HEAD


=======
<!-- /.tab-content -->
</div>
@endsection
>>>>>>> 00470bd13a3bedc4d46001d91b28d7d3ec90805a
