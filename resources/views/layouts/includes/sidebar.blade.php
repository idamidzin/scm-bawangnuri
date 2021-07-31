@php $role_id = auth()->user()->role_id; @endphp

<aside class="aside-container">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav class="sidebar" data-sidebar-anyclick-close="{{sizeof($sidebarMenu)}}">
            <!-- START sidebar nav-->
            <ul class="sidebar-nav">
                <!-- START user info-->
                <li class="has-user-block">
                    <div class="collapse" id="user-block">
                        <div class="item user-block">
                            <!-- User picture-->
                            <div class="user-block-picture">
                                <div class="user-block-status">
                                    <img class="img-thumbnail rounded-circle" src="/img/user/02.jpg" alt="Avatar" width="60" height="60" />
                                    <div class="circle bg-success circle-lg"></div>
                                </div>
                            </div>
                            <!-- Name and Job-->
                            <div class="user-block-info">
                                <span class="user-block-name">{{auth()->user()->nama}}</span>
                                <span class="user-block-role">Admin {{auth()->user()->nama}}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END user info-->

                @foreach ($sidebarMenu as $item)
                {{-- Headings --}}
                @if (isset($item['heading']))
                <li class="nav-heading ">
                    <span data-localize="{{$item['translate'] ?? ''}}">{{$item['text']}}</span>
                </li>

                {{-- Handle Submenus --}}
                @elseif (isset($item['submenu']))
                <?php $collapseId = 'menu-'.Str::slug($item['text']); ?>
                    @if(in_array($role_id, $item['role']))
                    <li class="{{ \Request::is($item['route'].'*') ? ' active' : '' }}">
                        <a href="{{'#'.$collapseId}}" title="{{$item['text']}}" data-toggle="collapse">
                            <em class="{{$item['icon']}}"></em>
                            <span data-localize="{{$item['translate'] ?? ''}}">{{$item['text']}}</span>
                        </a>
                        <ul class="sidebar-nav sidebar-subnav collapse {{ \Request::is($item['route'].'/*') ? 'show' : '' }}" id="{{$collapseId}}">
                            <li class="sidebar-subnav-header">{{$item['text']}}</li>

                            @foreach ($item['submenu'] as $subitem)

                            {{-- 2nd Level Handle Submenus --}}
                            @if (isset($subitem['submenu']))

                            <?php $collapseId = 'submenu-'.Str::slug($subitem['text']); ?>
                            <li class="{{ \Request::is($subitem['route'].'*') ? ' active' : '' }}">
                                <a href="{{'#'.$collapseId}}" title="{{$subitem['text']}}" data-toggle="collapse">
                                    <em class="{{$subitem['icon']}}"></em>
                                    <span data-localize="{{$subitem['translate'] ?? ''}}">{{$subitem['text']}}</span>
                                </a>
                                <ul class="sidebar-nav sidebar-subnav collapse {{ \Request::is($subitem['route'].'/*') ? 'show' : '' }}" id="{{$collapseId}}">
                                    <li class="sidebar-subnav-header">{{$subitem['text']}}</li>

                                    @foreach ($subitem['submenu'] as $subsubitem)
                                        <li class="{{ \Request::is($subsubitem['route']) ? ' active' : '' }}">
                                            <a href="{{ url($subsubitem['route']) }}" title="{{$subsubitem['text']}}">
                                                <span data-localize="{{$subsubitem['translate'] ?? ''}}">{{$subsubitem['text']}}</span>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>

                            {{-- 2nd Level Defualt to Single item --}}
                            @else
                            @if(in_array($role_id, $subitem['role']))
                            <li class="{{ \Request::is($subitem['route']) ? ' active' : '' }}" style="display: show;">
                                <a href="{{ url($subitem['route']) }}" title="{{$subitem['text']}}">
                                    <span data-localize="{{$subitem['translate'] ?? ''}}">{{$subitem['text']}}</span>
                                </a>
                            </li>
                            @endif
                            @endif

                            @endforeach
                        </ul>
                    </li>
                    @endif
                {{-- Default to Single item --}}
                @else
                    @if(in_array($role_id, $item['role']))
                    <li class="{{ \Request::is($item['route']) ? ' active' : '' }}" style="display: show;">
                        <a href="{{ url($item['route']) }}" title="{{$item['text']}}" id="{{ $item['id'] }}">
                            <em class="{{$item['icon']}}"></em>
                            <span data-localize="{{$item['translate'] ?? ''}}">{{$item['text']}}</span>
                            <!-- UNTUK ADMIN   -->
                            
                            @if($item['text'] == "Pesanan Produk" && $role_id == 1)
                                <div id="notif-pesanan-produk" class="float-right"></div>
                            @endif
                           
                            <!-- UNTUK SUPPLIER -->
                            
                            @if($item['text'] == "Pesanan" && $role_id == 2)
                                <div id="notif-pesanan" class="float-right"></div>
                            @endif
                            
                        </a>
                    </li>
                    @else
                    @endif
                @endif
                @endforeach
            </ul>
            <!-- END sidebar nav-->
        </nav>
    </div>
    <!-- END Sidebar (left)-->
</aside>
