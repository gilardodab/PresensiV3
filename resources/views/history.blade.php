@extends('layouts.app')

@section('content')
<div id="appCapsule">
    <div class="section mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker start_date" name="start_date" value="" placeholder="Tanggal Awal" required>
                                    <div class="input-group-addon">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <div class="input-group">
                                    <input type="text" name="end_date" class="form-control datepicker end_date" value="{{tanggal_ind(date('Y-m-d'))}}" placeholder="Tanggal Akhir">
                                    <div class="input-group-addon">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 justify-content-between">
                        <button type="button" class="btn btn-danger mt-1 btn-sortir btn-sm"><ion-icon name="checkmark-outline"></ion-icon>Tampilkan</button>
                        <button type="button" class="btn btn-success mt-1 btn-clear btn-sm"><ion-icon name="repeat-outline"></ion-icon> Clear</button>
                    </div>
                </div>       
            </div>
        </div>
        
    </div>
    

    <div class="section mt-2">
        {{-- <div class="section-title">Data Absensi</div> --}}
            {{-- <div class="table-responsive"> --}}
                <div class="loaddata"></div>
            {{-- </div> --}}
        <div class="alert alert-warning mt-2" role="alert">
            <ion-icon name="alert-circle-outline"></ion-icon> Untuk melihat foto absen silahkan klik pada waktu masuk/pulang.
        </div>
    </div>


    <!-- resources/views/partials/modal_print.blade.php -->
<div class="modal fade action-sheet inset" id="modal-print" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak / Export</h5>
                <a href="javascript:void(0);" class="close" style="position: absolute;right:15px;top: 10px;" data-dismiss="modal" aria-hidden="true">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Pilih Tipe</label>
                            <select class="form-control custom-select type" name="type" required>
                               <option value="pdf">PDF</option>
                               <option value="excel">EXCEL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <button type="button" class="btn btn-danger btn-block btn-lg mt-2 btn-print">
                            <ion-icon name="print-outline"></ion-icon> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade action-sheet inset" id="modal-show" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index:10000">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Absen Tanggal <span class="status-date badge badge-success"></span></h5>
                <a href="javascript:void(0);" class="close" style="position: absolute;right:15px;top: 10px;" data-dismiss="modal" aria-hidden="true">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">
                    <form id="update-history" method="POST" action="{{ route('history.update') }}">
                        @csrf
                        <input type="hidden" name="presence_id" id="presence_id" readonly>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Kehadiran</label>
                                <select class="form-control custom-select" name="present_id" id="status" required>
                                    @foreach($presentStatuses as $status)
                                        <option value="{{ $status->present_id }}">{{ $status->present_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <label class="label">Keterangan</label>
                            <div class="input-wrapper">
                                <textarea id="information" rows="2" class="form-control" name="information" placeholder="Keterangan"></textarea>
                            </div>
                            <span class="small">Kosongkan jika tidak memberi keterangan</span>
                        </div>

                        <div class="form-group basic">
                            <button type="submit" class="btn btn-danger btn-block btn-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
    loadData();

    function loadData() {
        $.ajax({
            url: '{{ route('history.load') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.loaddata').html(data);
            }
        });
    }

    $('.btn-clear').click(function (e) {
        loadData();
        $('.start_date').val('');
        $('.end_date').val('');
    });

    $('.btn-sortir').click(function (e) {
        var from = $('.start_date').val();
        var to = $('.end_date').val();

        $.ajax({
            url: '{{ route('history.load') }}',
            type: 'POST',
            data: {
                from: from,
                to: to,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                // Optionally show loader here
            },
            success: function(data) {
                $('.loaddata').html(data);
            },
            complete: function () {
                $(".loading").hide();
            }
        });
    });



    $('#update-history').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('history.update') }}',
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == 'success') {
                    swal({title: 'Berhasil!', text: 'Absensi berhasil diperbarui!', icon: 'success', timer: 2000});
                    $('#modal-show').modal('hide');
                    loadData();
                } else {
                    swal({title: 'Oops!', text: response, icon: 'error', timer: 2000});
                }
            }
        });
    });
</script>
@endpush
