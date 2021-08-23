
<div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
<div class="pcoded-inner-navbar main-menu">

    <!-- ROLE PENGUNJUNG -->
    @if(Auth::user()->role_id == 1)


<ul class="pcoded-item pcoded-left-item">
    <li class="">
        <a href="{{ route('landingpage-pengunjung') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext">Beranda</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>



<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('pengunjung-data_pemesanan')) ? 'active' : ''}}">
        <a href="{{ route('pengunjung-data_pemesanan') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-shopping-cart"></i><b>D</b></span>
            <span class="pcoded-mtext">Data Pemesanan</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('pengunjung-data_pembayaran')) ? 'active' : ''}}">
        <a href="{{ route('pengunjung-data_pembayaran') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-money"></i><b>D</b></span>
            <span class="pcoded-mtext">Data Pembayaran</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('pengunjung-profil')) ? 'active' : ''}}">
        <a href="{{ route('pengunjung-profil') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
            <span class="pcoded-mtext">Profil</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>
@endif



<!--============================================  ROLE ADMIN  ==============================================================-->
@if(Auth::user()->role_id == 2)



<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('admin-beranda')) ? 'active' : ''}}">
        <a href="{{ route('admin-beranda') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext">Beranda</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i><b>BC</b></span>
            <span class="pcoded-mtext">Data User</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{(request()->is('admin-data_pengunjung')) ? 'active' : ''}}">
                <a href="{{ route('admin-data_pengunjung') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pengunjung</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('admin-data_guide')) ? 'active' : ''}}">
                <a href="{{ route('admin-data_guide') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Guide</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
             <li class="{{(request()->is('admin-profil')) ? 'active' : ''}}">
                <a href="{{ route('admin-profil') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Profil Admin</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('admin-data_paket_wisata')) ? 'active' : ''}}">
        <a href="{{ route('admin-data_paket_wisata') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-map"></i><b>D</b></span>
            <span class="pcoded-mtext">Data Paket Wisata</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('admin-data_pemesanan_pengunjung')) ? 'active' : ''}}">
        <a href="{{ route('admin-data_pemesanan_pengunjung') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-shopping-cart"></i><b>D</b></span>
            <span class="pcoded-mtext">Data Pemesanan</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('admin-data_pembayaran_pengunjung')) ? 'active' : ''}}">
        <a href="{{ route('admin-data_pembayaran_pengunjung') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-money"></i><b>D</b></span>
            <span class="pcoded-mtext">Data Pembayaran</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-clipboard"></i><b>BC</b></span>
            <span class="pcoded-mtext">Laporan</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{(request()->is('admin-laporan_pengunjung')) ? 'active' : ''}}">
                <a href="{{ route('admin-laporan_pengunjung') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pengunjung</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('admin-laporan_pemesanan_paket')) ? 'active' : ''}}">
                <a href="{{ route('admin-laporan_pemesanan_paket') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pemesanan Paket</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('admin-laporan_pendapatan')) ? 'active' : ''}}">
                <a href="{{ route('admin-laporan_pendapatan') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pendapatan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
</ul>


<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('admin-galeri')) ? 'active' : ''}}">
        <a href="{{ route('admin-galeri') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-image"></i><b>D</b></span>
            <span class="pcoded-mtext">Kelola Galeri</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>


<ul class="pcoded-item pcoded-left-item">
    <li class="">
        <a href="{{ route('landingpage-pengunjung') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
            <span class="pcoded-mtext">Landingpage</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>
@endif



<!--================================================  ROLE GUIDE  ===================================================-->
@if(Auth::user()->role_id == 3)
<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('guide-beranda')) ? 'active' : ''}}">
        <a href="{{ route('guide-beranda') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext">Beranda</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('guide-jadwal')) ? 'active' : ''}}">
        <a href="{{ route('guide-jadwal') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-clipboard"></i><b>D</b></span>
            <span class="pcoded-mtext">Jadwal</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('guide-profil')) ? 'active' : ''}}">
        <a href="{{ route('guide-profil') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
            <span class="pcoded-mtext">Profil</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

@endif



<!--=======================================================  ROLE KEPALA DESA  =============================================-->
@if(Auth::user()->role_id == 4)
<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('kepala_desa-beranda')) ? 'active' : ''}}">
        <a href="{{ route('kepala_desa-beranda') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext">Beranda</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>



<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu {{(request()->is('kepala_desa-laporan_pengunjung')) ? 'active' : ''}}">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-clipboard"></i><b>BC</b></span>
            <span class="pcoded-mtext">Laporan</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{(request()->is('kepala_desa-laporan_pengunjung')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_pengunjung') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pengunjung</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('kepala_desa-laporan_pemesanan_paket')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_pemesanan_paket') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pemesanan Paket</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('kepala_desa-laporan_pendapatan')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_pendapatan') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Data Pendapatan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu {{(request()->is('kepala_desa-laporan_berkala_pengunjung')) ? 'active' : ''}}">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-agenda"></i><b>BC</b></span>
            <span class="pcoded-mtext">Laporan Berkala</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{(request()->is('kepala_desa-laporan_berkala_pengunjung')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_berkala_pengunjung') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Laporan Berkala Pengunjung</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('kepala_desa-laporan_berkala_pemesanan_paket')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_berkala_pemesanan_paket') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Laporan Berkala Pemesanan Paket</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{(request()->is('kepala_desa-laporan_berkala_pendapatan')) ? 'active' : ''}}">
                <a href="{{ route('kepala_desa-laporan_berkala_pendapatan') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Laporan Berkala Pendapatan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
</ul>


<ul class="pcoded-item pcoded-left-item">
    <li class="{{(request()->is('kepala_desa-profil')) ? 'active' : ''}}">
        <a href="{{ route('kepala_desa-profil') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
            <span class="pcoded-mtext">Profil</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>

@endif

</div>
