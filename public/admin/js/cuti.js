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
    
    function loading(){
        $(".loading").show();
        $(".loading").delay(1500).fadeOut(500);
    }
    
        /* -------------------- Edit ------------------- */
        $(document).on('click', '.update-status', function() {
            var id = $(this).attr("data-id");
            var status = $(this).attr("data-status");
        
            $.ajax({
                url: cutiUpdateUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    status: status
                },
                beforeSend: function() {
                    loading(); // Show loading state
                },
                success: function(response) {
                    if (response.status === 'success') {
                        swal({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2100);
                    } else {
                        swal({
                            title: 'Oops!',
                            text: response.message,
                            icon: 'error',
                            timer: 1500
                        });
                    }
                },
                complete: function() {
                    $(".loading").hide();
                },
                error: function(xhr) {
                    swal({
                        title: 'Error!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        timer: 1500
                    });
                }
            });
        });
        
    
    });