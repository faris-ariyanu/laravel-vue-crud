<nav id="sidebar" class="sidebar-fixed">
    <div class="logo">
        <img src="https://wrappixel.com/demos/admin-templates/admin-pro/assets/images/logo-light-text.png"/>
    </div>
    <div class="sidebar-nav">
        <ul class="list-unstyled components">
                <li>
                    <h5 style="padding: 10px 16px;border-bottom: 1px solid #404040;">Main Menu</h5>
                </li>
                @foreach($menus as $menu)
                    @if(!count($menu->item))
                        <li>
                            <a href="#/{{$menu->url}}"><i class="{{$menu->menu_value}}"></i>{{$menu->name}}</a>
                        </li>
                    @else
                        <li>
                            <a href="javascript:void(0)" data-target="#{{$menu->url}}" 
                                data-toggle="collapse" 
                                aria-expanded="false">
                              <i class="{{$menu->menu_value}}"></i>{{$menu->name}}
                            </a>
                            <ul class="collapse list-unstyled" id="{{$menu->url}}">
                                @foreach($menu->item as $item)
                                    <li>
                                        <a href="#/{{$item->url}}">
                                            <i class="{{$item->menu_value}}"></i>{{$item->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
    </div>
</nav>

<div id="mobile-sidebar" class="mobile-active">
        <div class="mobile-header"></div>
        <div class="mobile-nav">
            <ul class="list-unstyled components">
                @foreach($menus as $menu)
                    @if(!count($menu->item))
                        <li class="relative">
                            <a href="#/{{$menu->url}}"><i class="{{$menu->menu_value}}"></i></a>
                        </li>
                    @else
                        <li class="relative">
                            <a href="javascript:void(0)" data-target="#{{$menu->url}}" 
                                data-toggle="collapse" 
                                aria-expanded="false">
                              <i class="{{$menu->menu_value}}"></i>
                            </a>
                            <ul class="collapse list-unstyled" id="{{$menu->url}}">
                                <li style="background: #212330;"><a href="javascript:void(0)">{{$menu->name}} <i class="fa fa-caret-down fr"></i></a></li>
                                @foreach($menu->item as $item)
                                    <li>
                                        <a href="#/{{$item->url}}">
                                            {{$item->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>