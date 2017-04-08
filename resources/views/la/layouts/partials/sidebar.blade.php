<!-- 左侧列。 包含徽标和侧边栏 -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- 侧栏用户面板（可选） -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    {{--user的名字，由model提供--}}
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
                </div>
            </div>
        @endif

        <!-- 搜索框，可选 -->
        @if(LAConfigs::getByKey('sidebar_search'))
        <form action="/admin/search_group" method="get" class="sidebar-form">
            <div class="input-group">
	                <input type="text" name="q" class="form-control" placeholder="搜索群组"/>
              <span class="input-group-btn">
                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        
        <a href="/admin/add_group" type="button" class="btn btn-disabled btn-block" style="text-align:left;width:92%;margin:0 auto;" >创建群组</a>
        @endif
        <!-- /.search form -->

        <!-- 侧边的菜单 -->
        <ul class="sidebar-menu">
            <li class="header">模块</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url(config('laraadmin.adminRoute')) }}"><i class='fa fa-home'></i> <span>概览</span></a></li>
            <?php
            $menuItems = Dwij\Laraadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
            ?>

            @foreach ($menuItems as $menu)
                @if($menu->type == "module")
                    <?php
                    $temp_module_obj = Module::get($menu->name);
                    ?>
                    @la_access($temp_module_obj->id)
						@if(isset($module->id) && $module->name == $menu->name)
                        	<?php echo LAHelper::print_menu($menu ,true); ?>
						@else
							<?php echo LAHelper::print_menu($menu);?>
						@endif
                    @endla_access
                @else
                    <?php echo LAHelper::print_menu($menu);?>
                @endif
            @endforeach
            <!-- LAMenus -->
            
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
