<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        <ul class="am-list admin-sidebar-list">

            @foreach($menus as $menu)
                @if($menu->name=='admin')
                    <li>
                        <a href="{{route('admin')}}" class="{{ $parent_menu == '' ? 'am-active' : ''}}"><span
                                    class="am-icon-home"></span>  {{$menu->label}}</a>
                    </li>
                @else
                    <li class="admin-parent">
                        <a class="am-cf" data-am-collapse="{target: '#collapse-{{$menu->id}}'}">
                            <span class="{{$menu->icon}}"></span>
                            {{$menu->label}} <span class="am-icon-angle-right am-fr am-margin-right"></span>
                        </a>
                        <ul class="am-list am-collapse admin-sidebar-sub {{$parent_menu == $menu->name ? 'am-in' : ''}}"
                            id="collapse-{{$menu->id}}">
                            @foreach($menu->children as $children)
                                <li>
                                    @if(Route::has($children->name))
                                        <a href="{{route($children->name)}}"
                                           class="{{$children_menu == $children->name ? 'am-active' : ''}}">
                                            <span class="{{$children->icon}}"></span>
                                            {{$children->label}}
                                        </a>
                                    @else
                                        <a href="javascript: void 0;" class="error_permission">
                                            <span class="am-icon-close"></span> 权限定义错误
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>

        <div class="am-panel am-panel-default admin-sidebar-panel">
            <div class="am-panel-bd">
                <p><span class="am-icon-bookmark"></span> 思考</p>
                <p>{{$bibel['cn']}}</p>
            </div>
        </div>
        <div class="am-panel am-panel-default admin-sidebar-panel">
            <div class="am-panel-bd">
                <p><span class="am-icon-tag"></span> {{$config->author}}</p>
                <p>{{$bibel['en']}}</p>
            </div>
        </div>
    </div>
</div>