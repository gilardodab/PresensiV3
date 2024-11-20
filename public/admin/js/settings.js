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
$("#load").on("click", ".btn-reset", function(e) {
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