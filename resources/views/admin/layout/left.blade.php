<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                        <span class="clear">
                        <span class="block m-t-xs"><strong class="font-bold">Beaut-zihan</strong></span>
                        <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a></li>
                        <li><a class="J_menuItem" href="profile.html">个人资料</a></li>
                        <li><a class="J_menuItem" href="contacts.html">联系我们</a></li>
                        <li><a class="J_menuItem" href="mailbox.html">信箱</a></li>
                        <li class="divider"></li>
                        <li><a href="layout/logout">安全退出</a></li>
                    </ul>
                </div>
            </li>

            @foreach($menu as $item)
                @continue($item->status!=1)
                @empty($item->child)
                    <li>
                        <a class="J_menuItem" href="{{ $item->url }}" name="tabMenuItem">
                            <i class="{{ $item->icon }}"></i>
                            <span class="nav-label">{{ $item->title }}</span>
                        </a>
                    </li>
                @else
                <li>
                    <a href="javascript:void(0);">
                        <i class="{{ $item->icon }}"></i>
                        <span class="nav-label"> {{ $item->title }} </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        @foreach($item->child as $ite)
                            @continue($ite->status!=1)
                            @empty($ite->child)
                                <li>
                                    <a class="J_menuItem" href="{{ $ite->url }}" name="tabMenuItem">
                                        <i class="{{ $ite->ico }} nav-icon"></i>
                                        <span class="nav-label">{{ $ite->title }}</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="J_menuItem">
                                        {{ $ite->title }}
                                        <i class="{{ $ite->ico }} nav-icon"></i>
                                        <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-third-level" style="padding-left:20px;">
                                        @foreach($ite->child as $it)
                                            @continue($it->status!=1)
                                        <li>
                                            <a class="J_menuItem" href="{{ $it->url }}" name="tabMenuItem">
                                                {{ $it->title }}
                                                <i class="{{ $it->icon }} nav-icon"></i>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endempty
                        @endforeach
                    </ul>
                </li>
                @endempty
            @endforeach

            <li><a href="javascript:void(0);"></a></li>

        </ul>
    </div>
</nav>
