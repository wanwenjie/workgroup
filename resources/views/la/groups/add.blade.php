@extends('la.layouts.app')

@section('htmlheader_title') 创建群组 @endsection
@section('contentheader_title') 创建群组 @endsection
@section('contentheader_description') Organisation Overview @endsection

@section('main-content')
<div class="nav-tabs-custom">
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







