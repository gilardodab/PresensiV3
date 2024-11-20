<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      E-PRESENSI
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/adminyofa') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Data Master</li>
      <li class="nav-item {{ Request::is('karyawan', 'jabatan', 'shift', 'kantor') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#data-master" role="button" aria-expanded="{{ Request::is('karyawan', 'jabatan', 'shift', 'kantor') ? 'active' : '' }}" aria-controls="data-master">
          <i class="link-icon" data-feather="archive"></i>
          <span class="link-title">Data Master</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('karyawan', 'jabatan', 'shift', 'kantor') ? 'active' : '' }}" id="data-master">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/karyawan') }}" class="nav-link {{ Request::is('karyawan') ? 'active' : '' }}" >Karyawan</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/jabatan') }}" class="nav-link {{ Request::is('jabatan') ? 'active' : '' }}" >Jabatan</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/shift') }}" class="nav-link {{ Request::is('shift') ? 'active' : '' }}" >Jam Kerja</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/kantor') }}" class="nav-link {{ Request::is('kantor') ? 'active' : '' }}">Lokasi Kantor</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/email/compose') }}" class="nav-link {{ active_class(['email/compose']) }}">Outlet</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">Cuti</li>
      <li class="nav-item {{ Request::is('cutyadmin') ? 'active' : '' }}">
        <a href="{{ url('/cutyadmin') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Permohonan Cuti</span>
        </a>
      </li>
      <li class="nav-item nav-category">Laporan</li>
      <li class="nav-item {{ active_class(['ui-components/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="{{ is_active_route(['ui-components/*']) }}" aria-controls="uiComponents">
          <i class="link-icon" data-feather="feather"></i>
          <span class="link-title">Detail Laporan</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['ui-components/*']) }}" id="uiComponents">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/absensi') }}" class="nav-link {{ active_class(['ui-components/accordion']) }}">Presensi Harian</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/kunjunganadmin') }}" class="nav-link {{ active_class(['ui-components/accordion']) }}">Kunjungan</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/ui-components/accordion') }}" class="nav-link {{ active_class(['ui-components/accordion']) }}">Callplan</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/ui-components/accordion') }}" class="nav-link {{ active_class(['ui-components/accordion']) }}">Scan Alat</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">Pengaturan Aplikasi</li>
      <li class="nav-item {{ Request::is('settings') ? 'active' : '' }}">
        <a href="/settings" target="_blank" class="nav-link">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title">Pengaturan Aplikasi</span>
        </a>
      </li>
      <li class="nav-item nav-category">Admin</li>
      <li class="nav-item {{ Request::is('user') ? 'active' : '' }}">
        <a href="user" class="nav-link">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">User Admin</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
{{-- <nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted mb-2">Sidebar:</h6>
    <div class="mb-3 pb-3 border-bottom">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          Light
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          Dark
        </label>
      </div>
    </div>
    <div class="theme-wrapper">
      <h6 class="text-muted mb-2">Light Version:</h6>
      <a class="theme-item active" href="https://www.nobleui.com/laravel/template/demo1/">
        <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
      </a>
      <h6 class="text-muted mb-2">Dark Version:</h6>
      <a class="theme-item" href="https://www.nobleui.com/laravel/template/demo2/">
        <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
      </a>
    </div>
  </div>
</nav> --}}