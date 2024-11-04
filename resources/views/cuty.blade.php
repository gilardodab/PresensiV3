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
            <button type="button" class="btn btn-danger mt-1 btn-sortir-cuty">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96"/></svg>
                Tampilkan</button>
            <button type="button" class="btn btn-success mt-1 btn-clear-cuty">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m320 120l48 48l-48 48"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M352 168H144a80.24 80.24 0 0 0-80 80v16m128 128l-48-48l48-48"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M160 344h208a80.24 80.24 0 0 0 80-80v-16"/></svg>
                Clear</button>
            <button type="button" class="btn btn-warning mt-1" data-toggle="modal" data-target="#modal-add"><ion-icon name="add-circle-outline"></ion-icon> Tambah Cuti</button>
            
         </div>
 
         </div>       
     </div>
     </div>
     </div>
 
         <div class="section mt-2">
             <div class="section-title">Data Permohonan Cuti</div>
             <div class="card">
                 <div class="transactions">
                     <div class="loaddatacuty"></div>
                 </div>
             </div>
         </div>
     
 
         <!-- MODAL ADD -->
         <div class="modal fade modalbox" id="modal-add" tabindex="-1" role="dialog">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">Tambah Permohonan Cuti</h5>
                         <a href="javascript:;" data-dismiss="modal">Close</a>
                     </div>
                     <div class="modal-body">
                        <form id="form-add-cuty" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->employees_name}}" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Mulai Cuti</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="cutystart" name="cuty_start" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Berakhir Cuti</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="cutyend" name="cuty_end" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Masuk Kerja</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="date_work" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                             <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" name="cuty_total" value="" required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="2" class="form-control cuty_description" name="cuty_description" required></textarea>
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


        <!-- UPDATE DATA CUTY  -->
        <div class="modal fade modalbox" id="modal-update" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permohonan Cuti</h5>
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
                                    <label class="label">Mulai Cuti</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="cuty-start" name="cuty_start" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Berakhir Cuti</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="cuty-end" name="cuty_end" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Masuk Kerja</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="date-work" name="date_work" placeholder="" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                             <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" name="cuty_total" id="total" value="" required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                   <textarea rows="2" class="form-control cuty_description" id="cuty_description" name="cuty_description" required></textarea>
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
