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
                      <label for="inputEmail3" class="col-sm-2 control-label">群名称</label>

                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="group_name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">群组图片</label>
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
            </div>
            <!-- /.tab-content -->
          </div>
@endsection





