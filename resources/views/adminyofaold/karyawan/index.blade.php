@extends('layouts.masteradmin')

@section('content')
<div class="content-wrapper">
    @if(request()->route()->getName() == 'karyawan.create')
        <!-- Kode untuk case 'add' -->
        <section class="content-header">
            <h1>Tambah Data<small> Karyawan</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li><a href="{{ route('karyawan.index') }}">Data Karyawan</a></li>
                <li class="active">Tambah Karyawan</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Tambah Data Karyawan</b></h3>
                        </div>
    
                        <div class="box-body">
                            <form class="form-horizontal validate add-karyawan">
                                
                                <div class="box-body">
                                    <!-- Employees Code -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">No</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="employees_code" id="employees_code" value="{{ old('employees_code') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Employees Name -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="employees_name" id="employees_name" value="{{ old('employees_name') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Employees Email -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="employees_email" id="employees_email" value="{{ old('employees_email') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Employees Password -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="employees_password" id="employees_password" required>
                                        </div>
                                    </div>
                            
                                    <!-- Position -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Jabatan</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="position_id" id="position_id" required>
                                                <option value="">- Pilih -</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->position_id }}" {{ old('position_id') == $position->position_id ? 'selected' : '' }}>{{ $position->position_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    <!-- Shift -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Shift</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="shift_id" id="shift_id" required>
                                                <option value="">- Pilih -</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->shift_id }}" {{ old('shift_id') == $shift->shift_id ? 'selected' : '' }}>{{ $shift->shift_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    <!-- Building -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Penempatan</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="building_id" id="building_id" required>
                                                <option value="">- Pilih -</option>
                                                @foreach($buildings as $building)
                                                    <option value="{{ $building->building_id }}" {{ old('building_id') == $building->building_id ? 'selected' : '' }}>{{ $building->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    <!-- Photo -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Foto</label>
                                        <div class="col-sm-6">
                                            <img width="80" class="preview" src="{{ asset('admin/img/avatar.jpg') }}"><br><br>
                                            <input type="file" class="btn btn-default" name="photo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <!-- Box Footer -->
                                <div class="box-footer">
                                    <div class="col-sm-2"></div>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                    <a class="btn btn-danger" href="{{ route('karyawan.index') }}"><i class="fa fa-remove"></i> Batal</a>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @elseif(request()->route()->getName() == 'karyawan.edit')
        {{-- Form untuk Edit Karyawan --}}
        <section class="content-header">
            <h1>Edit Data<small> Karyawan</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li><a href="{{ route('karyawan.index') }}">Data Karyawan</a></li>
                <li class="active">Edit Karyawan</li>
            </ol>
        </section>
        
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Profil</a></li>
                                <li><a href="#tab_2" data-toggle="tab">Ubah Password</a></li>
                            </ul>
                        </div>
        
                        <div class="box-body">
                            <div class="nav-tabs-custom">
                                <div class="tab-content">
                                    <!-- Tab Profil -->
                                    <div class="tab-pane active" id="tab_1">
                                        <form class="form-horizontal validate update-karyawan" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT') <!-- Tambahkan method PUT untuk update -->
        
                                            <div class="box-body">
                                                <!-- Employees Code -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">NIK</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="employees_code" value="{{ $employee->employees_code }}" required>
                                                        <input type="hidden" name="id" value="{{ $employee->id }}" readonly required>
                                                    </div>
                                                </div>
        
                                                <!-- Employees Name -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Nama</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="employees_name" value="{{ $employee->employees_name }}" required>
                                                    </div>
                                                </div>
        
                                                <!-- Position -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Jabatan</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="position_id" required>
                                                            <option value="">- Pilih -</option>
                                                            @foreach($positions as $position)
                                                                <option value="{{ $position->position_id }}" {{ $employee->position_id == $position->position_id ? 'selected' : '' }}>
                                                                    {{ $position->position_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
        
                                                <!-- Shift -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Shift</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="shift_id" required>
                                                            <option value="">- Pilih -</option>
                                                            @foreach($shifts as $shift)
                                                                <option value="{{ $shift->shift_id }}" {{ $employee->shift_id == $shift->shift_id ? 'selected' : '' }}>
                                                                    {{ $shift->shift_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
        
                                                <!-- Building -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Penempatan</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="building_id" required>
                                                            <option value="">- Pilih -</option>
                                                            @foreach($buildings as $building)
                                                                <option value="{{ $building->building_id }}" {{ $employee->building_id == $building->building_id ? 'selected' : '' }}>
                                                                    {{ $building->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
        
                                                <!-- Photo -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Foto</label>
                                                    <div class="col-sm-6">
                                                        <div class="upload-media">
                                                            @if($employee->photo)
                                                                <img width="80" class="preview" src="{{ asset('storage/photos/'.$employee->photo) }}" >
                                                            @else
                                                                <img width="80" class="preview" src="{{ asset('content/avatar.jpg') }}">
                                                            @endif
                                                        </div>
                                                        <input type="file" class="btn btn-default" name="photo" accept="image/*">
                                                        <small>Kosongkan jika tidak ingin mengubah</small>
                                                    </div>
                                                </div>
                                            </div>
        
                                            <!-- Box Footer -->
                                            <div class="box-footer">
                                                <div class="col-sm-2"></div>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                                <a class="btn btn-danger" href="{{ route('karyawan.index') }}"><i class="fa fa-remove"></i> Batal</a>
                                            </div>
                                        </form>
                                    </div>
        
                                    <!-- Tab Ubah Password -->
                                    <div class="tab-pane" id="tab_2">
                                        <form class="form-horizontal validate update-password">
                                            @csrf
                                            @method('PUT')
    
                                            <div class="box-body">
                                                <!-- Employees Email -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Email</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="employees_email" value="{{ $employee->employees_email }}" readonly required>
                                                    </div>
                                                </div>
        
                                                <!-- Employees Password -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Password</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control" name="employees_password" placeholder="Password baru | Min 6 karakter" required>
                                                    </div>
                                                </div>
                                                        <!-- Konfirmasi Password -->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Konfirmasi Password</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control" name="employees_password_confirmation" id="password_confirmation"  placeholder="Konfirmasi Password" required>
                                                    </div>
                                                </div>
                                            </div>
        
                                            <!-- Box Footer -->
                                            <div class="box-footer">
                                                <div class="col-sm-2"></div>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                                <a class="btn btn-danger" href="{{ route('karyawan.index') }}"><i class="fa fa-remove"></i> Batal</a>
                                            </div>
                                        </form>
                                    </div>
                                </div> <!-- /.tab-content -->
                            </div> <!-- /.nav-tabs-custom -->
                        </div> <!-- /.box-body -->
                    </div> <!-- /.box box-solid -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </section>
    @else
        <!-- Default case -->
        <section class="content-header">
            <h1>Data<small> Karyawan</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Data Karyawan</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Data Karyawan</b></h3>
                            <div class="box-tools pull-right">
                                {{-- @if(Auth::check() && Auth::user()->level == 1) --}}
                                    <a href="#import" class="btn btn-warning" title="Import" data-toggle="modal"> Import</a>
                                    <a href="{{ route('karyawan.create') }}" class="btn btn-success btn-flat">
                                        <i class="fa fa-plus"></i> Tambah Baru
                                    </a>
                                {{-- @else
                                    <button type="button" class="btn btn-success btn-flat access-failed">
                                        <i class="fa fa-plus"></i> Tambah Baru
                                    </button>
                                @endif --}}
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="swdatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jabatan</th>
                                            <th>Shift</th>
                                            <th>Lokasi</th>
                                            <th style="width:150px" class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach($employees as $employee)
                                            @php $no++; @endphp
                                            <tr>
                                                <td class="text-center">{{ $no }}</td>
                                                <td>{{ $employee->employees_code }}</td>
                                                <td>{{ $employee->employees_name }}</td>
                                                <td>{{ $employee->employees_email }}</td>
                                                <!-- Access related data from position, shift, and building -->
                                                <td>{{ $employee->position->position_name ?? 'N/A' }}</td>
                                                <td>{{ $employee->shift->shift_name ?? 'N/A' }}</td>
                                                <td>{{ $employee->building->name ?? 'N/A' }}</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        @if($user->level == 1)
                                                            <a href="{{ route('karyawan.edit', $employee->id) }}" class="btn btn-warning btn-xs enable-tooltip" title="Edit">
                                                                <i class="fa fa-pencil-square-o"></i> Ubah
                                                            </a>
                                                            <button data-id="{{ $employee->id }}" class="btn btn-xs btn-danger delete" title="Hapus">
                                                                <i class="fa fa-trash-o"></i> Hapus
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit">
                                                                <i class="fa fa-pencil-square-o"></i> Ubah
                                                            </button>
                                                            <button type="button" class="btn btn-xs btn-danger access-failed" title="Hapus">
                                                                <i class="fa fa-trash-o"></i> Hapus
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <script>
        
    var karyawanStoreUrl = "{{ route('karyawan.store') }}";
    var karyawanUpdateUrl = "{{ route('karyawan.update', $employee->id) }}"; 
    var updatePasswordUrl = "{{ route('karyawan.update.password', $employee->id) }}";
    //delete karyawan.destroy with id
    var karyawanDeleteUrl = "{{ route('karyawan.destroy', '') }}";
</script>
<script src="{{ asset('admin/js/karyawan.js') }}"></script>
</div>

@endsection
