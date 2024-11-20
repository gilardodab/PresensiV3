@extends('layouts.masteradmin')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Setting Aplikasi</li>
    </ol>
  </nav>
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
  @switch(request()->get('op'))
  
      @case(null)
        <!-- Kode untuk case 'add' -->
      <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="settingumum-line-tab" data-bs-toggle="tab" data-bs-target="#settingumum" role="tab" aria-controls="settingumum" aria-selected="true" onclick="loadSettingUmum();">Pengaturan Aplikasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="settingprofile-line-tab" data-bs-toggle="tab" data-bs-target="#settingprofile" role="tab" aria-controls="settingprofile" aria-selected="false" onclick="loadSettingProfile();">Profile</a>
        </li>
      </ul>
      <div class="tab-content mt-3" id="lineTabContent">
        <div class="tab-pane fade show active" id="settingumum" role="tabpanel" aria-labelledby="settingumum-line-tab">
            <div id="loadsettingumum"></div>
        </div>
        
        <div class="tab-pane fade" id="settingprofile" role="tabpanel" aria-labelledby="settingprofile-line-tab">                          
            <div id="load"></div>
        </div>
      </div>
    </div>
    </div>
  </div>
  </div>
     <script>
            var settingUmumUrl = "{{ route('settings.umum') }}";
            var settingProfileUrl = "{{ route('settings.profile') }}";

            var updateSettingUrl = "{{ route('settings.update') }}";
            var updateProfileUrl = "{{ route('settings.profile') }}";
            // loadSettingUmum();
            // loadSettingProfile();
      </script>
      {{-- <script src="{{ asset('admin/js/settings.js') }}"></script> --}}
      @break

      @default
      <!-- You can add another section for different 'op' cases here -->

  @endswitch
{{-- <script>
    function loadSettingUmum(){
    $("#load").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    $("#load").load("");
}

function loadSettingProfile(){
    $("#load").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    $("#load").load("");
}


loadSettingUmum();
</script> --}}

            {{-- <h1>Pengaturan Situs</h1>
            <p>URL: {{ $setting->site_url }}</p>
            <p>Nama: {{ $setting->site_name }}</p>
            <p>Perusahaan: {{ $setting->site_company }}</p>
            <a href="{{ route('settings.edit') }}">Edit Pengaturan</a> --}}
@endsection
@push ('plugin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Load Setting
function loadSettingUmum() {
    $("#loadsettingumum").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    
    // Memanggil URL yang sudah di-generate di Blade
    $.ajax({
        url: settingUmumUrl, // URL dari Blade
        type: 'GET',
        success: function(response) {
            $("#loadsettingumum").html(response); // Masukkan response HTML ke div#load
        },
        error: function(xhr) {
            console.log("Error loading setting umum:", xhr.responseText);
        }
    });
}

function loadSettingProfile() {
    $("#load").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    
    // Menggunakan URL dari Blade yang disimpan di variabel

    $.ajax({
        url: settingProfileUrl,
        success: function(data) {
            $("#load").html(data); // Render HTML dari Blade
        },
        error: function(xhr, status, error) {
            console.log("Error loading setting profile: ", error);
        }
    });
}


$(document).ready(function() {
  function loading(){
      $(".loading").show();
      $(".loading").delay(1500).fadeOut(500);
  }

loadSettingUmum();

/* -------------------- Edit ------------------- */
// Update setting umum
$("#loadsettingumum").on("submit", ".update-setting", function(e) {
    e.preventDefault();
    $.ajax({
        url: updateSettingUrl,  // Gunakan variabel URL dari Blade
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(data) {
            if (data.success) {
                swal({title: 'Berhasil!', text: 'Pengaturan berhasil diperbarui.', icon: 'success', timer: 1500});
            } else {
                swal({title: 'Oops!', text: 'Ada kesalahan.', icon: 'error', timer: 1500});
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Untuk debugging error
        }
    });
});

// Update profile
$("#load").on("submit", ".update-profile", function(e) {
    e.preventDefault();
    $.ajax({
        url: updateProfileUrl,  // Gunakan variabel URL dari Blade
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(data) {
            if (data.success) {
                swal({title: 'Berhasil!', text: 'Profil berhasil diperbarui.', icon: 'success', timer: 1500});
            } else {
                swal({title: 'Oops!', text: 'Ada kesalahan.', icon: 'error', timer: 1500});
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Untuk debugging error
        }
    });
});

// Reset form pengaturan umum
$("#loadsettingumum").on("click", ".btn-reset", function(e) {
    e.preventDefault(); // Mencegah reload halaman

    // Reset semua input di dalam form dengan ID #validate
    $('#validate')[0].reset(); // Menggunakan DOM form reset() untuk mengembalikan nilai awal

    // Jika ada tampilan gambar (misal logo), kembalikan gambar default
    var defaultLogo = "assets/img/default-50x50.jpg";
    $("img.logo-preview").attr("src", defaultLogo); // Mengganti kembali preview logo jika ada
});

// Reset form profil
$("#load").on("click", ".btn-reset-profile", function(e) {
    e.preventDefault(); // Mencegah reload halaman

    // Reset semua input di dalam form profil
    $('.update-profile')[0].reset(); // Menggunakan DOM form reset()

    // Jika ada tampilan gambar atau informasi lain, reset juga jika diperlukan
});



$(".btn-print").on('click',function () {
    $("#printarea").show();
    window.print();
});


});
</script>
@endpush