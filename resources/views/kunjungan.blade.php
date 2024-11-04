@extends('layouts.app')

@section('content')

<div id="appCapsule">
         <div class="section mt-2">
             <div class="section-title">Jadwal Kunjungan Hari Ini</div>
             <div class="card">
                 <div class="transactions">
                     <div class="loaddatakunjungan"></div>
                 </div>
             </div>
         </div>

         <div class="section mt-2 text-center" >
            <button type="button" class="btn btn-danger btn-lg">UNPLAN</button>
        </div>
     
 
        <!-- UPDATE DATA CUTY  -->
        <div class="modal fade modalbox" id="modal-update" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kunjungan</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="form-update-cuty" autocomplete="off">
                            <input type="hidden" id="cuty-id" name="cuty_id" value="" readonly required>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->employees_name}}" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="2" class="form-control description" id="description" name="cuty_description" required></textarea>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <!-- * END UPDATE -->
</div>
@endsection
