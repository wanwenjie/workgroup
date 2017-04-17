<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- 搜索框 -->
        @if(LAConfigs::getByKey('sidebar_search'))
        <form action="/groups/search" method="post" class="sidebar-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-group">
	                <input type="text" name="q" class="form-control" placeholder="Search Group"/>
              <span class="input-group-btn">
                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        
        <a href="/admin/add_group" type="button" class="btn btn-disabled btn-block" style="text-align:left;width:92%;margin:0 auto;" >Create Group</a>
        @endif
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MODULES</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url(config('laraadmin.adminRoute')) }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
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
							<?php echo LAHelper::print_menu($menu); ?>
						@endif
                    @endla_access
                @else
                    <?php echo LAHelper::print_menu($menu); ?>
                @endif
            @endforeach
            <!-- LAMenus -->
            
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
