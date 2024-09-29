@extends ('layouts.app')

@section('content')

<div id="appCapsule">
    <!-- Wallet Card -->
    <div class="section wallet-card-section pt-1">
        <div class="wallet-card">
            <div class="balance">
                <div class="left">
                    <span class="title"> Selamat {{ $salam_info['salam'] }}</span>
                    <h4>{{ Auth::user()->employees_name }}</h4>
                </div>
                <div class="right">
                    <span class="title">{{hari_ini(date('Y-m-d'))}},{{tgl_ind(date('Y-m-d'))}}</span>
                    <h4><span class="clock"> </span></h4>
                </div>
            </div>
            <!-- * Balance -->
            <div class="text-center">
                <h5 style="margin-top: -5%;">Lat-Long: <span class="latitude" id="latitude"></span></h5>
            </div>
            <div class="wallet-footer text-center">
                <div class="webcam-capture-body text-center">
                    <div class="webcam-capture"></div>
                    <div class="form-group basic">
                            @if ($hasCheckedIn)
                            <button class="btn btn-success absent-capture btn-lg btn-block">
                                <ion-icon name="camera-outline"></ion-icon>Pulang
                            </button>
                            @else
                            <button class="btn btn-success absent-capture btn-lg btn-block">
                                <ion-icon name="camera-outline"></ion-icon>Masuk
                            </button>
                            @endif
                    </div>
                </div>
            </div>
            <!-- * Wallet Footer -->
        </div>
    </div>
    <!-- Card -->
</div>

{{-- @include('layouts.scripts') --}}

@endsection

