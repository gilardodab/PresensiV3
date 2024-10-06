$(document).ready(function() {
    $('#swdatatable').dataTable({
        "iDisplayLength": 20,
        "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]
    });
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
            url: karyawanStoreUrl,
            type: "POST",
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
    // Update Karyawan
    $('.update-karyawan').submit(function (e) {
        e.preventDefault(); // Prevent page reload

        if ($("#building").val() == "") {
            swal({ title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500 });
            return false;
        } else {
            var formData = new FormData(this);

            $.ajax({
                url: karyawanUpdateUrl, // Gunakan variabel yang sudah didefinisikan di Blade
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

        if ($("#password").val() == "") {
            swal({ title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500 });
            return false;
        } else {
            var formData = new FormData(this);

            $.ajax({
                url: updatePasswordUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                },
                beforeSend: function () {
                    // Tampilkan loading sebelum request
                    $(".loading").show();
                },
                success: function (data) {
                    if (data.success) {
                        swal({ title: 'Berhasil!', text: 'Password baru berhasil disimpan.!', icon: 'success', timer: 2000 });
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
        }
    });
    
    
    
    /*------------ Delete -------------*/
     $(document).on('click', '.delete', function(){ 
            var id = $(this).attr("data-id");
              swal({
                text: "Anda yakin menghapus data ini?",
                icon: "warning",
                  buttons: {
                    cancel: true,
                    confirm: true,
                  },
                value: "delete",
              })
    
              .then((value) => {
                if(value) {
                    loading();
                    $.ajax({  
                         url: karyawanDeleteUrl+ '/' + id,
                         type:'DELETE', 
                         headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
                        },   
                         data:{id:id},  
                        success:function(data){ 
                            if (data == 'success') {
                                swal({title: 'Berhasil!', text: 'Data berhasil dihapus.!', icon: 'success', timer: 1500});
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            } else {
                                swal({title: 'Gagal!', text: data, icon: 'error', timer: 1500,});
                                
                            }
                         }  
                    });  
               } else{  
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