<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @foreach (Helper::getMenunull() as $item)
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/' . $item->route) }}">
                <i class="{{ $item->icon }}"></i>
                <span>{{ $item->name }}</span></a>
        </li>
    @endforeach
    @foreach (Helper::getGroupmenu() as $groupmenu)
        @php
            $key = 0;
        @endphp
        @foreach ($groupmenu->Menu as $gm)
            @foreach ($gm->Authorization as $a)
                @if ($a->admin_groups_id == Auth::user()->admin_groups_id && $a->authorization_types_id == 1)
                    @if ($key != 1)
                        @php
                            $key = 1;
                        @endphp
                    @endif
                @endif
            @endforeach
        @endforeach
        <!-- Divider -->
        @if($key == 1)
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                <li data-toggle="collapse" data-target="#demo{{ $groupmenu->id }}" style="cursor: pointer">
                    <a>
                        <cite class="crossRotate"><span class="icon-note" style="font-size:18px; padding:10px;"></span>
                            {{ __('lang.' . $groupmenu->name) }} <p style="float: right" class="mt-2">▼</p><span
                                class="testRotate glyphicon glyphicon-menu-right pull-right small"
                                style="font-size:18px; padding:0 8px;"></span></cite>
                    </a>
                </li>
                {{-- {{$groupmenu->groupmenu}} --}}

                <div id="demo{{ $groupmenu->id }}" class="collapse">
                    <ul class="navbar-nav">
                        @foreach (Helper::getMenu() as $menu)
                            @if ($menu->menu_groups_id == $groupmenu->id)

                                <li class="nav-item pl-3 pb-0" role="presentation">
                                    <a class="nav-link text-white" role="menuitem"
                                        href="{{ url('/') }}/{{ $menu->route }}"
                                        style="font-size: 9px;line-height: 0"><i
                                            class="{{ $menu->icon }}"></i>{{ __('lang.' . $menu->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endforeach
    <hr class="sidebar-divider my-0">

</ul>
<script>
    $(document).on('click', '#drop', function(e) {
        $( ".collapse.show" ).removeClass( "show" );
        e.preventDefault();
    });
</script>
<!-- End of Sidebar -->
