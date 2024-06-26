@can('hrd')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center mt-0 bg-white">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="" height="30"></img>
        </div>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama_emp }}</div>
        </a>
        <div class="sidebar-brand-brand mx-3 mt-0 " height="15">
                    <p class="sidebar-brand-text align-items-left justify-content-center text-left text-white text-small">
                    Sistem Informasi pengajuan Cuti Online</br>
                    <b>PT Gastro Gizi Sarana</b></br>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</p>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.index') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.divisi') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Divisi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.jeniscuti') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Jenis Cuti</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.cuti') }}">
                <i class="fa fa-info-circle"></i>
                <span>Cuti</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.manajer') }}">
                <i class="fa fa-info-circle"></i>
                <span>Data Manajer</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hrd.karyawan') }}">
                <i class="fa fa-light fa-newspaper"></i>
                <span>Data Karyawan</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
@endcan
@can('manajer')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center mt-0 bg-white">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="" height="30"></img>
        </div>
        <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-text mx-3">
                <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama_emp }}</div>
                
            </div>
        </a>
        <div class="sidebar-brand-brand mx-3 mt-0 " height="15">
                <p class="sidebar-brand-text align-items-left justify-content-center text-left text-white text-small">
                Sistem Informasi pengajuan Cuti Online</br>
                   <b>PT Gastro Gizi Sarana</b></br>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</p>
        </div>
        <hr class="sidebar-divider my-0">
        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manajer.index') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manajer.cuti') }}">
                <i class="fa fa-info-circle"></i>
                <span>Cuti</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manajer.karyawan') }}">
                <i class="fa fa-light fa-newspaper"></i>
                <span>Data Karyawan</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Sidebar Toggler (Sidebar) -->
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span></a>
        </li>
    </ul>
    </ul>
@endcan
@can('karyawan')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand-icon d-flex align-items-center justify-content-center mt-0 bg-white">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="" height="30"></img>
        </div>
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-text mx-3">
                <div class="sidebar-brand-text mx-3">{{ Auth::user()->nama_emp }}</div>
                
            </div>
        </a>
        <div class="sidebar-brand-brand mx-3 mt-0 " height="15">
            <p class="sidebar-brand-text align-items-left justify-content-center text-left text-white text-small">
                Sistem Informasi pengajuan Cuti Online</br>
                   <b>PT Gastro Gizi Sarana</b></br>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</p>
        </div>
        <hr class="sidebar-divider my-0">
        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.cuti') }}">
                <i class="fa fa-light fa-user-pen"></i>
                <span>Data Cuti</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Sidebar Toggler (Sidebar) -->
        <li class="nav-item">
            <a class="nav-link" href="/logout">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span></a>
        </li>
    </ul>
    </ul>
@endcan
