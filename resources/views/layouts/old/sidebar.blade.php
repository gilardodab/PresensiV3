<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <div class="slimScrollDiv">
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <li class="{{ Request::is('adminyofa') ? 'active' : '' }}">
          <a href="{{ url('/adminyofa') }}">
            <i class="fa fa-home"></i><span>Dashboard</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('karyawan', 'jabatan', 'shift', 'kantor') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-database"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('karyawan') ? 'active' : '' }}">
              <a href="{{ url('/karyawan') }}">
                <i class="fa fa-circle-o"></i> Data Karyawan
              </a>
            </li>
            <li class="{{ Request::is('jabatan') ? 'active' : '' }}">
              <a href="{{ url('/jabatan') }}">
                <i class="fa fa-circle-o"></i> Data Jabatan
              </a>
            </li>
            <li class="{{ Request::is('shift') ? 'active' : '' }}">
              <a href="{{ url('/shift') }}">
                <i class="fa fa-circle-o"></i> Data Jam Kerja
              </a>
            </li>
            <li class="{{ Request::is('kantor') ? 'active' : '' }}">
              <a href="{{ url('/kantor') }}">
                <i class="fa fa-circle-o"></i> Data Lokasi
              </a>
            </li>
            
          </ul>
        </li>

        <li class="{{ Request::is('cutyadmin') ? 'active' : '' }}">
          <a href="{{ url('/cutyadmin') }}">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>Permohonan Cuti</span>
          </a>
        </li>

        <li class="{{ Request::is('absensi') ? 'active' : '' }}">
          <a href="{{ url('/absensi') }}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>Data Presensi Harian</span>
          </a>
        </li>

        <li class="{{ Request::is('absensim') ? 'active' : '' }}">
          <a href="{{ url('/absensim') }}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>Data Absensi Kunjungan</span>
          </a>
        </li>

        <li class="{{ Request::is('callplan') ? 'active' : '' }}">
          <a href="{{ url('/callplan') }}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>Data Call Plan</span>
          </a>
        </li>

        <li class="{{ Request::is('settings') ? 'active' : '' }}">
          <a href="{{ url('/settings') }}">
            <i class="fa fa-cogs" aria-hidden="true"></i>
            <span>Pengaturan</span>
          </a>
        </li>

        <li class="{{ Request::is('user') ? 'active' : '' }}">
          <a href="{{ url('/user') }}">
            <i class="fa fa-user"></i>
            <span>Admin</span>
          </a>
        </li>
        
        <li>
          <form id="logout-form" action="{{ route('logoutadmin') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fa fa-sign-out"></i> Logout
      </a>
        </li>
      </ul>
    </section>
  </div>
  <!-- /.sidebar -->
</aside>
