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
                        <input type="text" class="form-control datepicker start_date" name="start_date" placeholder="Tanggal Awal" required>
                        <div class="input-group-addon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4  col-md-4">
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
            <button type="button" class="btn btn-danger mt-1 btn-sortir-callpan">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96"/></svg>
                Tampilkan</button>
            <button type="button" class="btn btn-success mt-1 btn-clear-callpan">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m320 120l48 48l-48 48"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M352 168H144a80.24 80.24 0 0 0-80 80v16m128 128l-48-48l48-48"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M160 344h208a80.24 80.24 0 0 0 80-80v-16"/></svg>
                Refresh</button>
            <button type="button" class="btn btn-warning mt-1" data-toggle="modal" data-target="#modal-add"><ion-icon name="add-circle-outline"></ion-icon> Tambah Callplan</button>
         </div>
          </div>       
     </div>
     </div>
     </div>
 
         <div class="section mt-2">
             <div class="section-title">Data Callplan</div>
             <div class="card">
                 <div class="transactions">
                     <div class="loaddatacallplan"></div>
                 </div>
             </div>
         </div>
     
 
         <!-- MODAL ADD -->
         <div class="modal fade modalbox" id="modal-add" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Call Plan</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="form-add-callplan" autocomplete="off">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->employees_name }}" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>
        
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Mulai :</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tanggal_cp" name="tanggal_cp" placeholder="DD-MM-YYYY" required>
                                        <div class="input-group-addon">
                                            <ion-icon name="calendar-outline"></ion-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Outlet</label>
                                    <input type="text" class="form-control" name="nama_outlet" placeholder="Misal Puskesmas Sleman" required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>
        
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                    <textarea rows="4" class="form-control description" name="description" placeholder="Isi Uraian/Keterangan, Misal: Follow Up Alat HB" ></textarea>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>
        
                            <div class="form-group basic">
                                <button type="submit" class="btn btn-primary btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


        <!-- UPDATE DATA CUTY  -->
        <div class="modal fade modalbox" id="modal-update" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Callplan</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="form-update-callplan" autocomplete="off">
                            <input type="hidden" id="callplan-id" name="callpan_id" value="" readonly required>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->employees_name}}" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Mulai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="tanggal_cp" name="tanggal_cp" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama Outlet</label>
                                   <textarea rows="1" class="form-control nama_outlet" id="nama_outlet" name="nama_outlet" value="" required></textarea>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="4" class="form-control description" id="description" name="description" required></textarea>
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
