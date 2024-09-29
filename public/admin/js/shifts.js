
jQuery(document).ready(function() {
    jQuery('#datatable').dataTable({
        "iDisplayLength": 20,
        "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Timepicker
    $('.timepicker').timepicker({
        showInputs: false,
        showMeridian: false,
        use24hours: true,
        format: 'HH:mm'
    });

    // Show loading
    function loading() {
        $(".loading").show();
    }

    // Hide loading
    function hideLoading() {
        $(".loading").fadeOut(500);
    }

    // Add Shift
    $('.add-shift').submit(function (e) {
        e.preventDefault();

        // Validation
        let valid = true;
        $('.add-shift input[type=text]').each(function() {
            if ($(this).val() === '') {
                valid = false;
                swal({title: 'Oops!', text: 'Harap semua bidang inputan diisi.!', icon: 'error', timer: 1500});
                return false;
            }
        });
        if (!valid) return;

        // Submit form via AJAX
        loading();
        let $this = $(this);
        $this.find('button[type="submit"]').prop('disabled', true); // Disable submit button
        console.log(shiftStoreUrl); // Check if the URL is correct
        $.ajax({
            
            url: shiftStoreUrl,
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
                    swal({title: 'Berhasil!', text: 'Data Shift berhasil disimpan.!', icon: 'success', timer: 1500});
                    $('#modalAdd').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    swal({title: 'Oops!', text: data, icon: 'error', timer: 1500});
                }
            },
            complete: function () {
                hideLoading();
                $this.find('button[type="submit"]').prop('disabled', false); // Re-enable button
            }
        });
    });

    // Edit Shift
    $('.update-shift').submit(function (e) {
        e.preventDefault();
    
        if ($('#txtname').val() == '') {
            swal({title: 'Oops!', text: 'Harap semua bidang inputan diisi.!', icon: 'error', timer: 1500});
            loading();
            return false;
        }
    
        loading();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');  // Append _method to simulate PUT request
    
        $.ajax({
            url: shiftUpdateUrl + '/' + $('#txtid').val(),
            type: "POST",  // Keep the request type as POST
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
            },
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                if (data == 'success') {
                    swal({title: 'Berhasil!', text: 'Data Shift berhasil diupdate.!', icon: 'success', timer: 1500});
                    $('#modalEdit').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    swal({title: 'Oops!', text: data, icon: 'error', timer: 1500});
                }
            },
            complete: function () {
                hideLoading();
            }
        });
    });
    


    // Delete Shift
    $(document).on('click', '.delete', function () {
        var id = $(this).attr("data-id");
    
        swal({
            text: "Anda yakin menghapus data ini?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true
            },
            value: "delete",
        }).then((value) => {
            if (value) {
                loading();
                $.ajax({
                    url: shiftDeleteUrl + '/' + id, // Append ID to the URL
                    type: 'DELETE',  // Use DELETE method
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
                    },
                    success: function (data) {
                        if (data == 'success') {
                            swal({title: 'Berhasil!', text: 'Data berhasil dihapus.!', icon: 'success', timer: 1500});
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            swal({title: 'Gagal!', text: data, icon: 'error', timer: 1500});
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: " + error);
                        swal({title: 'Gagal!', text: 'Terjadi kesalahan saat menghapus data.', icon: 'error', timer: 1500});
                    }
                });
            } else {
                return false;
            }
        });
    });
    
});
