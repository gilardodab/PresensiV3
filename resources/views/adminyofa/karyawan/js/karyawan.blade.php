<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('.preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    
    $("#imgInp").change(function() {
      readURL(this);
    });
    
    
    function loading(){
        $(".loading").show();
        $(".loading").delay(1500).fadeOut(500);
    }
    
    /* ----------- Add ------------*/
    $('.add-karyawan').submit(function (e) {
        e.preventDefault();  // Prevent default form submission
    
        if ($('#building_id').val() == '') {
            swal({
                title: 'Oops!',
                text: 'Harap bidang inputan tidak boleh ada yang kosong.!',
                icon: 'error',
                timer: 1500
            });
            return false; // Exit the function if validation fails
        }
    
        loading();  // Show loading indicator
    
        var formData = new FormData(this);  // Use FormData for file uploads
    
        $.ajax({
            url: '{{ route('karyawan.store') }}',
            type: "POST",
            _token: "{{ csrf_token() }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                if (data.status === 'success') {
                    swal({
                        title: 'Berhasil!',
                        text: 'Data Karyawan berhasil disimpan.!',
                        icon: 'success',
                        timer: 1500,
                    });
                    setTimeout(function () {
                        window.location.href = "/karyawan";  // Redirect after success
                    }, 2500);
                } else {
                    swal({
                        title: 'Oops!',
                        text: data.errors ? data.errors.join(', ') : data.message,
                        icon: 'error',
                        timer: 1500,
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error Status: ", xhr.status);  // Log the status code
                console.error("AJAX Error Details: ", error);  // Log the error
                console.error("Full Response: ", xhr.responseText);  // Log the full response
    
                swal({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data. Status: ' + xhr.status,
                    icon: 'error',
                    timer: 1500,
                });
            },
            complete: function () {
                $(".loading").hide();  // Hide the loading indicator
            }
        });
    });
    
    
    
    /* -------------------- Edit ------------------- */
    // Update Karyawan
    $('.update-karyawan').submit(function (e) {
        e.preventDefault(); // Prevent page reload
        var id = $(this).find('button[type="submit"]').data("id");
        if ($("#building").val() == "") {
            swal({ title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500 });
            return false;
        } else {
            var formData = new FormData(this);

            $.ajax({
                url: `/karyawan/${id}/update-profile`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                beforeSend: function () {
                    $(".loading").show();
                },
                success: function (data) {
                    if (data.success) {
                        swal({ title: 'Berhasil!', text: 'Data Karyawan berhasil disimpan.!', icon: 'success', timer: 1500 });
                        setTimeout(function () { location.reload(); }, 1500);
                    } else {
                        swal({ title: 'Oops!', text: data.error, icon: 'error', timer: 1500 });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
                complete: function () {
                    $(".loading").hide();
                }
            });
        }
    });


    // Update Password
    $('.update-password').submit(function (e) {
        e.preventDefault(); // Mencegah refresh halaman
        var id = $(this).find('button[type="submit"]').data("id");
        // Ambil nilai input dan periksa apakah ada yang kosong
        var password = $("#password").val().trim();
        var passwordConfirmation = $("#password_confirmation").val().trim();

        if (password === "" || passwordConfirmation === "") {
            swal({ title: 'Oops!', text: 'Harap semua bidang input diisi!', icon: 'error', timer: 1500 });
            return false;
        }

        // Pastikan password dan konfirmasi password sama
        if (password !== passwordConfirmation) {
            swal({ title: 'Oops!', text: 'Password dan konfirmasi password tidak cocok!', icon: 'error', timer: 1500 });
            return false;
        }

        var formData = new FormData(this);

        $.ajax({
            url: `/karyawan/${id}/update-password`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
            },
            beforeSend: function () {
                $(".loading").show(); // Tampilkan loading sebelum request
            },
            success: function (data) {
                if (data.success) {
                    swal({ title: 'Berhasil!', text: 'Password baru berhasil disimpan.', icon: 'success', timer: 2000 });
                    setTimeout(function () { location.reload(); }, 2000); // Reload setelah 2 detik
                } else {
                    swal({ title: 'Oops!', text: data.error, icon: 'error', timer: 1500 });
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Untuk debug jika ada error
            },
            complete: function () {
                $(".loading").hide(); // Sembunyikan loading setelah request selesai
            }
        });
    });


    
    
    
    /*------------ Delete -------------*/
    $(document).on('click', '.delete', function() {
    var id = $(this).attr("data-id");
    swal({
        text: "Anda yakin menghapus data ini?",
        icon: "warning",
        buttons: {
            cancel: true,
            confirm: true,
        },
    })
    .then((value) => {
        if (value) {
            loading();
            $.ajax({
                url: `/karyawan/${id}`,  // Template literal untuk URL
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id: id},
                beforeSend: function() {
                    $(".loading").show();
                },
                success: function(response) {
                    if (response.status === 'success') {
                        swal({ title: 'Berhasil!', text: response.message, icon: 'success', timer: 1500 });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        swal({ title: 'Gagal!', text: response.message, icon: 'error', timer: 1500 });
                    }
                },
                error: function(xhr) {
                    swal({ title: 'Error!', text: 'Terjadi kesalahan, silakan coba lagi.', icon: 'error', timer: 1500 });
                    console.error(xhr.responseText);  // Debugging untuk melihat error di console
                }
            });
        } else {
            return false;
        }
    });
});

    
    
    /* ----------- Import ------------*/
    $('.import').submit(function (e) {
            loading();
            e.preventDefault();
            $.ajax({
                url:"",
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function () { 
                  loading();
                },
                success: function (data) {
                    if (data == 'success') {
                        swal({title: 'Berhasil!', text: 'Data Karyawan berhasil diimport.!', icon: 'success', timer: 2500,});
                       window.setTimeout(window.location.href = "./karyawan",2500);
                    } else {
                        swal({title: 'Oops!', text: data, icon: 'error', timer: 2500,});
                    }
    
                },
                complete: function () {
                    $(".loading").hide();
                },
            });
      });
    
    
    });
</script>