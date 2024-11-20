<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="mail"></i>
          @if ($cuti->count() > 0 )
          <div class="indicator">
            <div class="circle"></div>
          </div>
          @endif
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="messageDropdown">
          <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
            <p>{{$cuti->count()}} Pengajuan Cuti baru</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
          </div>
          @forelse ($cuti as $item)
          <div class="p-1">
            <a href="/cutyadmin" class="dropdown-item d-flex align-items-center py-2">
              <div class="me-3">
                <img class="wd-30 ht-30 rounded-circle" src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="d-flex justify-content-between flex-grow-1">
                <div class="me-4">
                  <p>{{$item->employeess->employees_name}}</p>
                  <p class="tx-12 text-muted">Cuti : {{$item->cuty_start }} sampai {{$item->cuty_end}}</p>
                </div>
                <p class="tx-12 text-muted"><span class="badge bg-danger">Total Cuti : {{$item->cuty_total}}</span> </p>
              </div>	
            </a>
            @empty
            <p class="text-center">Tidak ada data</p>
          </div>
          @endforelse
          <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
            <a href="/cutyadmin">View all</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          @if ($presence->count() > 0)
          <div class="indicator">
            <div class="circle"></div>
          </div>
          @endif
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
          <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
            <p>{{$presence->count()}} New Notifications</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
          </div>
          @forelse ($presence as $item)
          <div class="p-1">
            <a href="/absensi" class="dropdown-item d-flex align-items-center py-2">
              <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                <i class="icon-sm text-white" data-feather="clock"></i>
              </div>
              <div class="flex-grow-1 me-2">
                <p>Absen Masuk :</p>
                <p class="tx-12 text-muted"> {{$item->time_in}}</p>
              </div>
              <div class="flex-grow-1 me-2">
                <p>Absen Pulang :</p>
                <p class="tx-12 text-muted"> {{$item->time_out}}</p>
              </div>	
            </a>
          </div>
          <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
            <a href="/absensi">View all</a>
          </div>
          @empty
          <p class="text-center">Tidak ada data</p>
          @endforelse
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ asset('content/avatar.jpg') }}" alt="picture" class="wd-30 ht-30 rounded-circle">
        </a>
        <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
          <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
            <div class="mb-3">
              <img class="wd-80 ht-80 rounded-circle" src="{{ asset('content/avatar.jpg') }}" alt="">
            </div>
            <div class="text-center">
              <p class="tx-16 fw-bolder">{{$user->username}}</p>
              <p class="tx-12 text-muted">{{$user->email}}</p>
              {{-- <p class="tx-12 text-muted">{{$user->level_name}}</p> --}}
              
            </div>
          </div>
          <ul class="list-unstyled p-1">
            <li class="dropdown-item py-2">
              <a href="{{ url('profileadmin') }}" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="user"></i>
                <span>Profile</span>
              </a>
            </li>
            {{-- <li class="dropdown-item py-2">
              <a href="javascript:;" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="edit"></i>
                <span>Edit Profile</span>
              </a>
            </li>
            <li class="dropdown-item py-2">
              <a href="javascript:;" class="text-body ms-0">
                <i class="me-2 icon-md" data-feather="repeat"></i>
                <span>Switch User</span>
              </a>
            </li> --}}


            <!-- Modify the logout link to use JavaScript to submit the form -->
            <li class="dropdown-item py-2">
              <form id="logout-form" action="{{ route('logoutadmin') }}" method="POST" style="display: none;">
                @csrf
            </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="me-2 icon-md" data-feather="log-out"></i>
                  <span>Log Out</span>
                </a>
            </li>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>