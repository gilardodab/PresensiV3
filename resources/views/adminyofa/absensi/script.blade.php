<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    $('#datatable').dataTable({
        "iDisplayLength":31,
        "aLengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]],
    });

    function loading(){
        $(".loading").show();
        $(".loading").delay(1500).fadeOut(500);
    }

    loadData();

function loadData() {
    var id = $('.id').val(); // Pastikan elemen ini ada di halaman
    
    $.ajax({
        url: '{{ url('/absensi') }}',
        type: 'POST', // Jika Anda tidak memerlukan POST, ubah menjadi 'GET'
        data: {
            id: id,
            
            _token: '{{ csrf_token() }}'
        },
        
        success: function(data) {
            
            $('.loaddata').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error); // Log error untuk debugging
            alert("Terjadi kesalahan: " + xhr.responseText); // Memberikan umpan balik kepada pengguna
        }
    });
}


    $('.btn-clear').click(function (e) {
        loadData();
        $('.month').val('');
        $('.year').val('');
    });

    $('.btn-sortir').click(function (e) {
        // console.log('{{ url('/absensi') }}+'?op=views&id='+id+'')');
            var month_d = new Array();
            month_d[0] = "January";
            month_d[1] = "February";
            month_d[2] = "March";
            month_d[3] = "April";
            month_d[4] = "May";
            month_d[5] = "June";
            month_d[6] = "July";
            month_d[7] = "August";
            month_d[8] = "September";
            month_d[9] = "October";
            month_d[10] = "November";
            month_d[11] = "December";

            var id    = $('.id').val();
            var month = $('.month').val();
            var year  = $('.year').val();

            var d     = new Date(month);
            var n     = month_d[d.getMonth()];
            //document.getElementById("demo").innerHTML = n;
            $('.result-month').html(n);
            console.log(month);
        $.ajax({
            url: '{{ url('/absensi') }}',
            method:"POST",
            data:{month:month,year:year},
            dataType:"text",
            cache: false,
            async: false,
                beforeSend: function () { 
                //loading();
                },
                success: function (data) {
                $('.loaddata').html(data);
                },
            complete: function () {
                //$(".loading").hide();
            },
        });
    });

    (function() {
        var $gallery = new SimpleLightbox(".picture a", {});
    })();


        $('.btn-print').click(function (e) {
                var id    = $('.id').val();
                var month = $('.month').val();
                var year  = $('.year').val();
                var type  = $(this).attr("data-id");
            
                if(type =='pdf'){
                    // cek berdasarkan bulan
                    if(month==''){    
                        var url = "./absensi/print?action=pdfid="+id+"";
                    }else{
                        var url = "./absensi/print?action=pdf&id="+id+"&from="+month+"&to="+year+"";
                    }
                }

                if(type=='excel'){
                    if(month==''){    
                        var url = "./absensi/print?action=excel&id="+id+"";
                    }else{
                        var url = "./absensi/print?action=excel&id="+id+"&from="+month+"&to="+year+"";
                    }
                }

                if(type=='print'){
                    var url = "./absensi/print?action=excel&id="+id+"&from="+month+"&to="+year+"&print=print";
                }
                window.open(url, '_blank');
        });

        $('.btn-print-all').click(function (e) {
                var month = $('.month').val();
                var year  = $('.year').val();
                var type  = $('.type').val();
                if(type =='pdf'){
                    // cek berdasarkan bulan
                    var url = "./absensi/print?action=allpdf&from="+month+"&to="+year+"";
                }
                if(type=='excel'){
                    var url = "./absensi/print?action=allexcel&from="+month+"&to="+year+""; 
                }
                if(type=='print'){
                    var url = "./absensi/print?action=allexcel&from="+month+"&to="+year+"&print=print"; 
                }

                window.open(url, '_blank');
        });

    });


    $(document).on('click', '.btn-modal', function(){
        $('#modal-location').modal();
        var latitude  = $(this).attr("data-latitude");
        var longitude = $(this).attr("data-longitude");
        var name = $('.employees_name').html();
        $(".modal-title-name").html(name);
       
    });

    $(".image-link").magnificPopup({type:"image"});
</script>
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>