<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav class="navbar topnavbar">
        <!-- START navbar header-->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="brand-logo">
                    <strong style="color: white">
                        {{ 'Bawang Goreng Nuri' }}
                    </strong>
                </div>
                <div class="brand-logo-collapsed">
                    <img class="img-fluid" src="{{ asset('logo.png') }}" alt="App Logo" />
                </div>
            </a>
        </div>
        <!-- END navbar header-->
        <!-- START Left navbar-->
        <ul class="navbar-nav mr-auto flex-row">
            <li class="nav-item">
                <a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
                    <em class="fas fa-bars"></em>
                </a>
                <a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
                    <em class="fas fa-bars"></em>
                </a>
            </li>
        </ul>
        <!-- END Left navbar-->
        <!-- START Right Navbar-->
        <ul class="navbar-nav flex-row">
            <!-- START Offsidebar button-->
            <li class="nav-item dropdown dropdown-list">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-toggle="dropdown">
                    <em>{{ auth()->user()->nama }}</em>
                </a>
                <!-- START Dropdown menu-->
                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                    <div class="dropdown-item">
                        <!-- START list group-->
                        <div class="list-group">
                            <!-- list item-->
                            <div class="list-group-item list-group-item-action">
                                <div class="media">
                                    <div class="align-self-start mr-2">
                                        <a href="{{route('logout')}}" ><em class="fa-2x icon-logout text-info"></em></a>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="m-0">Logout</h5>
                                        <h5 class="m-0 text-muted text-sm">Silahkan keluar disini</h5>
                                    </div>
                                </div>
                            </div>
                        <!-- END list group-->
                    </div>
                </div>
                <!-- END Dropdown menu-->
            </li>
            <!-- END Offsidebar menu-->
        </ul>
        <!-- END Right Navbar-->
        <!-- START Search form-->
        <form class="navbar-form" role="search" action="#">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Type and hit enter ..." />
                <div class="fas fa-times navbar-form-close" data-search-dismiss=""></div>
            </div>
            <button class="d-none" type="submit">Submit</button>
        </form>
        <!-- END Search form-->
    </nav>
    <!-- END Top Navbar-->
</header>
