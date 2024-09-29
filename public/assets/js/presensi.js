$(document).ready(function() {
    // Get the CSRF token from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    function loading(){
        $(".loading").show();
        $(".loading").delay(2000).fadeOut(600);
    }

    function loadDataCounter() {
        $.ajax({
            url: loadhomeUrl,
            type: 'POST',
            success: function(data) {
                $('.load-home').html(data);
            }
        });
    }
    loadDataCounter();
    $('.select-change').on('change', function() {
        var month_filter = this.value;
        $.ajax({
            url: loadhomeUrl,
            method: "POST",
            data: { month_filter: month_filter },
            dataType: "text",
            cache: false,
            async: false,
            beforeSend: function() {
                loading();
            },
            success: function(data) {
                $('.load-home').html(data);
            },
            complete: function() {
                $(".loading").hide();
            }
        });
    });

    $(document).on("click", ".access-failed", function() {
        swal({ title: "Error!", text: "Anda tidak memiliki hak akses lagi!", icon: "error", timer: 2500 });
    });
});
