<div id="sidebar" class="sidebar py-3">
    <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">MAIN</div>
    <ul class="sidebar-menu list-unstyled">
        <li class="sidebar-list-item"><a href="{{ route('home.index') }}" class="sidebar-link text-muted {{ str_contains(Route::currentRouteName() , 'home') ? 'active' : '' }}"><i
                    class="o-home-1 mr-3 text-gray"></i><span>Home</span></a></li>

        <li class="sidebar-list-item">
            <a href="{{ route('magazines.index') }}"
               class="sidebar-link text-muted {{ str_contains(Route::currentRouteName() , 'magazines') ? 'active' : '' }}">
                <i class="fa fa-newspaper mr-3 text-gray"></i>
                <span>Magazines</span> </a>
        </li>

        <li class="sidebar-list-item"><a href="{{ route('users.index') }}" class="sidebar-link text-muted {{ str_contains(Route::currentRouteName() , 'users') ? 'active' : '' }}"><i
                    class="fa fa-users mr-3 text-gray"></i><span>Users</span></a></li>
        <li class="sidebar-list-item"><a href="{{ route('front.index') }}" class="sidebar-link text-muted {{ str_contains(Route::currentRouteName() , 'users') ? 'active' : '' }}"><i
                    class="fa fa-eye mr-3 text-gray"></i><span>Public</span></a></li>
       {{-- <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false"
                                         aria-controls="pages" class="sidebar-link text-muted"><i
                    class="o-wireframe-1 mr-3 text-gray"></i><span>Pages</span></a>
            <div id="pages" class="collapse">
                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page one</a></li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page two</a></li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page three</a>
                    </li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page four</a></li>
                </ul>
            </div>
        </li>--}}
    </ul>
   {{-- <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">EXTRAS</div>
    <ul class="sidebar-menu list-unstyled">
        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><i
                    class="o-database-1 mr-3 text-gray"></i><span>Demo</span></a></li>
        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><i
                    class="o-imac-screen-1 mr-3 text-gray"></i><span>Demo</span></a></li>
        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><i
                    class="o-paperwork-1 mr-3 text-gray"></i><span>Demo</span></a></li>
        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><i
                    class="o-wireframe-1 mr-3 text-gray"></i><span>Demo</span></a></li>
    </ul>--}}
</div>
