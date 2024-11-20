<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#datatable').dataTable({
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



    loadData();

    function loadData() {
    var id = $('.id').val(); // Ambil nilai ID karyawan dari elemen input
    
    $.ajax({
        url: '{{ route('absensi.load') }}', // Panggil rute untuk memuat data absensi
        type: 'GET',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            $('.loaddata').html(data); // Tampilkan data yang diterima di elemen loaddata
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
            alert("Terjadi kesalahan: " + xhr.responseText);
        }
    });
}



    $('.btn-clear').click(function (e) {
        loadData();
        $('.month').val('');
        $('.year').val('');
    });

    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });
    
    $('.btn-sortir').click(function(e) {
        var id = $('.id').val();
        var dateRange = $('input[name="daterange"]').val();
        var [startDate, endDate] = dateRange.split(' - ');

        $.ajax({
            url: '{{ route('absensi.load') }}',
            method: 'POST',
            data: {
                id: id,
                start_date: startDate,
                end_date: endDate,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.loaddata').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert("Terjadi kesalahan: " + xhr.responseText);
            }
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