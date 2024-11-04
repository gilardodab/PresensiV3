
        <!-- App Header -->
        <div class="appHeader bg-purple text-light">
            <div class="left">
                <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-miterlimit="10" stroke-width="48" d="M88 152h336M88 256h336M88 360h336"/></svg>
                </a>
            </div>
            <div class="pageTitle">
                <h3 class="text-light">E-PRESENSI</h3>
            </div>
            <div class="right">
                <div class="headerButton" data-toggle="dropdown" id="dropdownMenuLink" aria-haspopup="true">
                    @if(Auth::user()->photo == '')
                        <img src="{{ asset('content/avatar.jpg') }}" alt="picture" class="imaged w32 rounded">
                    @else
                        <img src="{{ asset('storage/photos/' . Auth::user()->photo ) }}" alt="picture" class="imaged w32 rounded">
                    @endif

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a href="{{ url('profile') }}" class="dropdown-item" ><ion-icon size="small" name="person-outline"></ion-icon> Profil</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <ion-icon size="small" name="log-out-outline"></ion-icon> Keluar
                        </a>
                    </div>
                </div>
            </div>
            <div class="progress" style="display:none;position:absolute;top:50px;z-index:4;left:0px;width: 100%">
                <div id="progressBar" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only">0%</span>
                </div>
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Sidebar -->
        <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <!-- profile box -->
                        <div class="profileBox pt-2 pb-2">
                            <div class="image-wrapper">
                           @if(Auth::user()->photo == '')
                                <img src="{{ asset('content/avatar.jpg') }}" alt="picture" class="imaged w36 rounded">
                            @else
                                <img src="{{ asset('storage/photos/' . Auth::user()->photo ) }}" alt="picture" class="imaged w36 rounded">
                            @endif
  
                            </div>
                            <div class="in">
                                <strong>{{ Auth::user()->employees_name }}</strong>
                                <div class="text-muted"></div>
                            </div>
                            <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </div>
                        <!-- * profile box -->

                        <!-- menu -->
                        <div class="listview-title mt-1">Absen</div>
                        <ul class="listview flush transparent no-line image-listview">
                            <li>
                                <a href="./" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M80 212v236a16 16 0 0 0 16 16h96V328a24 24 0 0 1 24-24h80a24 24 0 0 1 24 24v136h96a16 16 0 0 0 16-16V212"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M480 256L266.89 52c-5-5.28-16.69-5.34-21.78 0L32 256m368-77V64h-48v69"/></svg>
                                    </div> Home 
                                </a>
                            </li>
                            <li>
                                <a href="./present" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="44" d="M342 444h46a56 56 0 0 0 56-56v-46m0-172v-46a56 56 0 0 0-56-56h-46M170 444h-46a56 56 0 0 1-56-56v-46m0-172v-46a56 56 0 0 1 56-56h46"/></svg>
                                    </div> Absen
                                </a>
                            </li>
                            <li>
                                <a href="./cuty" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><rect width="416" height="384" x="48" y="80" fill="none" stroke="white" stroke-linejoin="round" stroke-width="32" rx="48"/><circle cx="296" cy="232" r="24" fill="white"/><circle cx="376" cy="232" r="24" fill="white"/><circle cx="296" cy="312" r="24" fill="white"/><circle cx="376" cy="312" r="24" fill="white"/><circle cx="136" cy="312" r="24" fill="white"/><circle cx="216" cy="312" r="24" fill="white"/><circle cx="136" cy="392" r="24" fill="white"/><circle cx="216" cy="392" r="24" fill="white"/><circle cx="296" cy="392" r="24" fill="white"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M128 48v32m256-32v32"/><path fill="none" stroke="white" stroke-linejoin="round" stroke-width="32" d="M464 160H48"/></svg>
                                    </div> Cuti
                                </a>
                            </li>
                            <li>
                                <a href="./history" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linejoin="round" stroke-width="32" d="M416 221.25V416a48 48 0 0 1-48 48H144a48 48 0 0 1-48-48V96a48 48 0 0 1 48-48h98.75a32 32 0 0 1 22.62 9.37l141.26 141.26a32 32 0 0 1 9.37 22.62Z"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 56v120a32 32 0 0 0 32 32h120m-232 80h160m-160 80h160"/></svg>
                                    </div> History
                                </a>
                            </li>
                            <li>
                                <a href="profile" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96"/><path fill="none" stroke="white" stroke-miterlimit="10" stroke-width="32" d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304Z"/></svg>
                                    </div> Profil
                                </a>
                            </li>
                            <li>
                                <a href="./logout" class="item">
                                    <div class="icon-box bg-purle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M304 336v40a40 40 0 0 1-40 40H104a40 40 0 0 1-40-40V136a40 40 0 0 1 40-40h152c22.09 0 48 17.91 48 40v40m64 160l80-80l-80-80m-192 80h256"/></svg>
                                    </div> Keluar
                                </a>
                            </li>
                        </ul>
                        <!-- * menu -->
                    </div>
                </div>
            </div>
        </div>
        <!-- * App Sidebar -->

