<div class="quixnav-scroll">
    <ul class="metismenu" id="menu">
        <li class="nav-label first">Main Menu</li>
        <li><a href="{{route('dashboard.index')}}"><i class="icon icon-home"></i><span class="nav-text">Dashboard</span></a></li>
        <li><a href="{{route('dashboard.ami.index')}}"><i class="icon icon-home"></i><span class="nav-text">Dashboard AMI</span></a></li>

        {{-- ami MENU --}}
        <li class="nav-label">AMI Menu</li>
        <li><a href="{{route('ami.index')}}">
                <i class="fa-solid fa-award"></i><span>AMI</span>
            </a>
        </li>

        <li class="nav-label">Standar Menu</li>
        <li><a class="has-arrow" href="javascript:void('')" aria-expanded="false"><i
                    class="icon icon-layers-3"></i><span
                    class="nav-text">Standar</span></a>
            <ul aria-expanded="false">

                <li><a href="{{route('standar.index')}}">List Standar</a></li>

                @if(session('roleUserLogin') === 'admin')
                    <li><a href="{{route('standar.add.form')}}">Tambah Standar</a></li>
                @endif
            </ul>
        </li>

        @if(session('roleUserLogin') === 'admin')
            <li class="nav-label">Indikator Menu</li>
            <li><a class="has-arrow" href="javascript:void('')" aria-expanded="false"><i
                        class="mdi mdi-format-list-bulleted"></i><span
                        class="nav-text">Indikator</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{route('indikator.index')}}">List Indikator</a></li>
                    <li><a href="{{route('indikator.add.form')}}">Tambah Indikator</a></li>
                </ul>
            </li>

            <li class="nav-label">User Menu</li>
            <li><a class="has-arrow" href="javascript:void('')" aria-expanded="false"><i
                        class="icon icon-users-mm"></i><span
                        class="nav-text">User</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{route('user.index')}}">List User</a></li>
                    <li><a href="{{route('user.add.index')}}">Tambah User</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>

<!--**********************************
            Sidebar end
***********************************-->
