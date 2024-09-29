
        <!-- App Header -->
        <div class="appHeader bg-purple text-light">
            <div class="left">
                <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                    <ion-icon name="menu-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">
                <h3 class="text-light">E-PRESENSI</h3>
            </div>
            <div class="right">
                <div class="headerButton" data-toggle="dropdown" id="dropdownMenuLink" aria-haspopup="true">

                        <img src="content/avatar.jpg" alt="image" class="imaged w32">

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
                                    <img src=" content/avatar.jpg" alt="image" class="imaged w36">
  
                            </div>
                            <div class="in">
                                <strong></strong>
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
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="home-outline"></ion-icon>
                                    </div> Home 
                                </a>
                            </li>
                            <li>
                                <a href="./present" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="scan-outline"></ion-icon>
                                    </div> Absen
                                </a>
                            </li>
                            <li>
                                <a href="./cuty" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div> Cuti
                                </a>
                            </li>
                            <li>
                                <a href="./history" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="document-text-outline"></ion-icon>
                                    </div> History
                                </a>
                            </li>
                            <li>
                                <a href="profile" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="person-outline"></ion-icon>
                                    </div> Profil
                                </a>
                            </li>
                            <li>
                                <a href="./logout" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="log-out-outline"></ion-icon>
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

