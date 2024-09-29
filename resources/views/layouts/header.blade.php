<header class="main-header">
    <a href="{{ url('/') }}" class="logo">
      <span class="logo-mini"><b>E-PRESENSI</span>
      <span class="logo-lg"><b>E-PRESENSI</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu pull-left">
        <ul class="nav navbar-nav">
          <li><a href="#"></a></li>
        </ul>
      </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li><a href="{{ url('/') }}" target="_blank"><i class="fa fa-desktop" aria-hidden="true"></i></a></li>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-calendar" aria-hidden="true"></i>
              <span class="label label-warning">{{$cuti->count()}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki  notifikasi</li>
              <li>
                <ul class="menu">
                  
                    <li>
                      <a href="">
                        @forelse ($cuti as $item)
                        <i class="fa fa-calendar text-aqua"></i>Cuti 
                        : {{$item->cuty_start }}sampai {{$item->cuty_end}} <br>
                        <label class="label label-warning">Jumlah: </label>
                        @empty
                        <i class="fa fa-calendar text-aqua"></i>Tidak Ada Cuti
                        @endforelse
                      </a>
                    </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{$presence->count()}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki  notifikasi</li>
              <li>
                <ul class="menu">
                  
                    <li>
                      <a href="">
                        @forelse ($presence as $item)
                        <i class="fa fa-sign-in text-aqua"></i>Absen Masuk : {{$item->time_in}}<br>
                          <i class="fa fa-sign-out text-aqua"></i>Absen Pulang :
                        @empty
                        <i class="fa fa-sign-in text-aqua"></i>Belum Ada Presensi 
                        @endforelse
                      </a>
                    </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{$user->username}}<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                {{-- logout method POST --}}
              <li><a href="{{ url('profileadmin') }}"><i class="fa fa-user"></i> Profile</a></li>

              <li><a href="{{ url('settingadmin') }}"><i class="fa fa-cogs"></i> Pengaturan</a></li>

              <li role="separator" class="divider"></li>
                <!-- Include the logout form somewhere in your Blade template -->
                <form id="logout-form" action="{{ route('logoutadmin') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <!-- Modify the logout link to use JavaScript to submit the form -->
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>

            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <div class="slimScrollDiv">
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        
        <li class="active">
          <a href="{{ url('/adminyofa/dashboard') }}">
            <i class="fa fa-home"></i><span>Dashboard</span>
          </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <li class="treeview">
                <a href="#">
                  <i class="fa fa-database"></i> <span>Master Data</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">

                   <a href="./karyawan"><i class="fa fa-circle-o"></i> Data Karyawan</a></li>
                   <a href="./jabatan"><i class="fa fa-circle-o"></i> Data Jabatan</a></li>
                   <a href="shift"><i class="fa fa-circle-o"></i> Data Jam Kerja</a></li>
                   <a href="./lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
                </ul>
              </li>

        <li>
          <a href="{{ url('cutyadmin') }}"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Data Permohonan Cuti</span></a>
        </li>

        <li>
          <a href="{{ url('/absensi') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Absensi Harian</span></a>
        </li>

        <li>
          <a href="{{ url('/absensim') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Absensi Kunjungan</span></a>
        </li>

        <li>
          <a href="{{ url('/callplan') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Call Plan</span></a>
        </li>

        <li>
          <a href="{{ url('/setting') }}"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Pengaturan</span></a>
        </li>

        <li>
          <a href="{{ url('/user') }}"><i class="fa fa-user"></i> <span>Admin</span></a>
        </li>
        
        <li>
          <a href="javascript:void(0);" onclick="location.href='{{ url('/logout') }}';">
            <i class="fa fa-sign-out text-red"></i> <span>Keluar</span>
          </a>
        </li>
      </ul>
    </section>
  </div>
  <!-- /.sidebar -->
</aside>
