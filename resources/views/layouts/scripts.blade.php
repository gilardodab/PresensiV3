<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
<!-- Base Js File -->
<script src="{{ asset('assets/js/base.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/webcamjs/webcam.min.js') }}"></script>
<script src="{{ asset('assets/js/presensi.js') }}"></script>
{{-- <script src="{{ asset('assets/__manifest.json') }}"></script>
<script src="{{ asset('assets/__service-worker.json') }}"></script> --}}

<script>
    var loadhomeUrl = "{{ route('load.home.counter') }}";
    var loadhistoryUrl = "{{ route('history.load') }}";
    var updatehistory = "{{ route('history.update') }}";

    var loadcutyUrl = "{{ route('cuty.load') }}";
    var storecutyUrl = "{{ route('cuty.store') }}";
    var updatecutyUrl = "{{ route('cuty.update') }}";

    var updateprofileUrl = "{{ route('profile.update') }}";
    var updatephotoprofileUrl = "{{ route('profile.updatephoto') }}";



</script>
@if(Request::is('history') || Request::is('cuty'))
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
    });
</script>
@endif

<script src="{{ asset('assets/js/script.js') }}"></script>


@if(Request::is('absent'))
<script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
<script type="text/javascript">
    var latitude_building = L.latLng({{ $building->latitude_longtitude }});
    navigator.geolocation.getCurrentPosition(function(location) {
        var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
        var markerFrom = L.circleMarker(latitude_building, { color: "#F00", radius: 10 });
        var markerTo = L.circleMarker(latlng);
        var from = markerFrom.getLatLng();
        var to = markerTo.getLatLng();
        var jarak = from.distanceTo(to).toFixed(0);
        var latitude = "" + location.coords.latitude + "," + location.coords.longitude;
        $("#latitude").text(latitude);

        Webcam.set({
            width: 590,
            height: 700,
            image_format: 'jpeg',
            jpeg_quality: 80,
        });

        var cameras = [];
        navigator.mediaDevices.enumerateDevices().then(function(devices) {
            devices.forEach(function(device, i) {
                if(device.kind === "videoinput") {
                    cameras[i] = device.deviceId;
                }
            });
        });

        Webcam.set('constraints', {
            width: 590,
            height: 700,
            image_format: 'jpeg',
            jpeg_quality: 80,
            sourceId: cameras[0]
        });

        Webcam.attach('.webcam-capture');

        var shutter = new Audio();
        shutter.src = navigator.userAgent.match(/Firefox/) ? 'assets/js/webcamjs/shutter.ogg' : 'assets/js/webcamjs/shutter.mp3';

        $(document).on('click', '.absent-capture', function() { 
    shutter.play();

    // Tangkap gambar dari Webcam
    Webcam.snap(function(data_uri) {
        // Dapatkan data latitude dan jarak (radius)
        var latitude = $('#latitude').text();  // Pastikan elemen #latitude ada di HTML
        var jarak = $('#radius').text();       // Pastikan elemen #radius ada di HTML
        var homeUrl = "/home";
        // Mengirim data ke server menggunakan AJAX
        $.ajax({
            url: '{{ route('presences.store') }}',  // Menggunakan route yang telah dibuat
            type: 'POST',
            data: {
                webcam: data_uri,  // Base64 data dari webcam
                latitude: latitude,  // Mengirim latitude
                radius: jarak,       // Mengirim radius
                _token: '{{ csrf_token() }}' // Sertakan CSRF token untuk keamanan
            },
            success: function(response) {
                var resultStatus = response.status;
                var resultMessage = response.message;

                if(resultStatus === 'success') {
                    swal({
                        title: 'Berhasil!',
                        text: resultMessage,
                        icon: 'success',
                        timer: 3500,
                    });
                    setTimeout(function() {
                        window.location.href = homeUrl;
                    }, 3600);
                } else {
                    swal({
                        title: 'Oops!',
                        text: resultMessage,
                        icon: 'error',
                        timer: 3500,
                    });
                    setTimeout(function() {
                        window.location.href = homeUrl;
                    }, 3600);
                }
            },
            error: function(xhr) {
                console.log("Error response: ", xhr.responseText); // Tambahkan log untuk mengetahui error dari server
                swal({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat absen.' + xhr.responseText,
                    icon: 'error',
                    timer: 3500,
                });
                    // Ambil URL home dari Laravel
                    

                setTimeout(function() {
                    // Redirect ke home
                    window.location.href = homeUrl;
                }, 3600); // Timer untuk redirect (sesuai timer swal)
            }
        });
    });
});

    });
</script>
@endif