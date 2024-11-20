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

         <div class="section mt-2 mb-2 text-center" >
            {{-- <button type="button" class="btn btn-danger btn-lg ">UNPLAN</button> --}}
            <a href="./unplan" style="border-radius: 20px;">
                <div class="icon-wrapper bg-danger"><strong>UNPLAN</strong>
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="13" r="3"/><path d="M9.778 21h4.444c3.121 0 4.682 0 5.803-.735a4.4 4.4 0 0 0 1.226-1.204c.749-1.1.749-2.633.749-5.697s0-4.597-.749-5.697a4.4 4.4 0 0 0-1.226-1.204c-.72-.473-1.622-.642-3.003-.702c-.659 0-1.226-.49-1.355-1.125A2.064 2.064 0 0 0 13.634 3h-3.268c-.988 0-1.839.685-2.033 1.636c-.129.635-.696 1.125-1.355 1.125c-1.38.06-2.282.23-3.003.702A4.4 4.4 0 0 0 2.75 7.667C2 8.767 2 10.299 2 13.364s0 4.596.749 5.697c.324.476.74.885 1.226 1.204C5.096 21 6.657 21 9.778 21Z"/><path stroke-linecap="round" d="M19 10h-1"/></g></svg>
                </div>
                
            </a>
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
