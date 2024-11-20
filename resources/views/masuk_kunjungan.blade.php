@extends('layouts.app')

@section('content')

<div id="appCapsule">
    <!-- Wallet Card -->
    <div class="section wallet-card-section pt-1">
        <div class="wallet-card">
            <div class="balance">
                <div class="left">
                    {{-- <span class="title">Selamat {{ $salam_info['salam'] }}</span> --}}
                    <h4>{{ Auth::user()->employees_name }}</h4>
                </div>
                <div class="right">
                    <span class="title">{{ hari_ini(date('Y-m-d')) }}, {{ tgl_ind(date('Y-m-d')) }}</span>
                    <h4><span class="clock"></span></h4>
                </div>
            </div>
            <!-- * Balance -->
            <div class="text-center">
                <h5 style="margin-top: -5%;">{{$kunjungan}}</h5>
                <h5 style="margin-top: -5%;">Lat-Long: <span id="latitude"></span></h5>
            </div>
            <div class="wallet-footer text-center">
                <div class="webcam-capture-body text-center">
                    <div class="webcam-capture"></div>
                    <div class="form-group basic">
                        <button class="btn btn-success absent-capture btn-lg btn-block">
                            <ion-icon name="camera-outline"></ion-icon>Masuk Tempat
                        </button>
                    </div>
                </div>
            </div>
            <!-- * Wallet Footer -->
        </div>
    </div>
    <!-- Card -->
</div>

@endsection

@push('custom-scripts')
<script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        navigator.geolocation.getCurrentPosition(function(location) {
            var latitude = "" + location.coords.latitude + "," + location.coords.longitude;
            $("#latitude").text(latitude);

            Webcam.set({
                width: 590,
                height: 700,
                image_format: 'jpeg',
                jpeg_quality: 80
            });
            Webcam.attach('.webcam-capture');

            var shutter = new Audio();
            shutter.src = navigator.userAgent.match(/Firefox/) ? 'assets/js/webcamjs/shutter.ogg' : 'assets/js/webcamjs/shutter.mp3';

            $('.absent-capture').click(function() {
                shutter.play();
                Webcam.snap(function(data_uri) {
                    $.ajax({
                        url: '{{ route('kunjungan.store') }}',
                        type: 'POST',
                        data: {
                            webcam: data_uri,
                            latitude: latitude,
                            kunjungan_id: "{{$kunjungan}}",
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            swal({
                                title: response.status === 'success' ? 'Berhasil!' : 'Oops!',
                                text: response.message,
                                icon: response.status === 'success' ? 'success' : 'error'
                            }).then(() => {
                                window.location.href = '/home';
                            });
                        },
                        error: function(xhr) {
                            swal({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat absen.',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        });
    });
</script>
@endpush
