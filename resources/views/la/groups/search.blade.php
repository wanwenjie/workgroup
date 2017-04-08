@extends('la.layouts.app')

@section('htmlheader_title') 搜索群组 @endsection
@section('contentheader_title') 搜索群组 @endsection
@section('contentheader_description') Organisation Overview @endsection

@section('main-content')
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
@endsection





