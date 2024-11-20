@extends('layouts.masteradmin')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
  </ol>
</nav>

<div class="row">
        <!-- Kode untuk case 'add' -->
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    @if(request()->route()->getName() == 'karyawan.index')
    <div class="card-body">
      <h6 class="card-title">Data Karyawan</h6>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-mb-3">
        <a href="#import" class="btn btn-warning" title="Import" data-toggle="modal"> Import</a>
        <a href="{{ route('karyawan.create') }}" class="btn btn-success btn-flat">
            <i class="fa fa-plus"></i> Tambah Baru
        </a>
      </div>
      <div class="table-responsive">
        <table id="dataTableExample" class="table">
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
    @elseif(request()->route()->getName() == 'karyawan.create')
      <div class="card-body">
        <h6 class="card-title">Tambah Data Karyawan</h6>
        <form class="form-horizontal validate add-karyawan">    
          @csrf    
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
      @elseif(request()->route()->getName() == 'karyawan.edit')
      {{-- Form untuk Edit Karyawan --}}
      <div class="card-body">
        <h6 class="card-title">Edit Karyawan</h6>
        <div class="container mb-3">
            <ul class="nav nav-tabs" id="lineTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-line-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menupassword-line-tab" data-bs-toggle="tab" href="#menupassword" role="tab" aria-controls="menupassword" aria-selected="false">Password</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="lineTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
                    <form class="form-horizontal validate update-karyawan" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">No HP</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="employees_code" value="{{ $employee->employees_code }}" required>
                                <input type="hidden" name="id" value="{{ $employee->id }}" readonly>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="employees_name" value="{{ $employee->employees_name }}" required>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jabatan</label>
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
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Shift</label>
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
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Penempatan</label>
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
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-6">
                                <div class="upload-media mb-2">
                                    @if($employee->photo)
                                        <img width="80" class="preview img-thumbnail" src="{{ asset('storage/photos/'.$employee->photo) }}">
                                    @else
                                        <img width="80" class="preview img-thumbnail" src="{{ asset('content/avatar.jpg') }}">
                                    @endif
                                </div>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah</small>
                            </div>
                        </div>
    
                        <div class="d-flex justify-content-start">
                            <button type="submit" data-id="{{ $employee->id }}" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a class="btn btn-danger ms-2" href="{{ route('karyawan.index') }}"><i class="fa fa-remove"></i> Batal</a>
                        </div>
                    </form>
                </div>
    
                <div class="tab-pane fade" id="menupassword" role="tabpanel" aria-labelledby="menupassword-line-tab">
                    <form class="form-horizontal validate update-password">
                        @csrf
                        @method('PUT')
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="employees_email" value="{{ $employee->employees_email }}" readonly required>
                            </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label">Password</label>
                          <div class="col-sm-6">
                              <div class="input-group">
                                  <input type="password" class="form-control" name="employees_password" id="password" placeholder="Password baru | Min 6 karakter" required>
                                  <div class="input-group-append">
                                      <span class="input-group-text" onclick="togglePassword()">
                                        <i class="eye-icon" data-feather="eye"></i>
                                      </span>
                                  </div>
                              </div>
                          </div>
                      </div>
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-6">
                              <div class="input-group">
                                <input type="password" class="form-control" name="employees_password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                                <div class="input-group-append">
                                  <span class="input-group-text" onclick="togglePassword()">
                                    <i class="eye-icon" data-feather="eye"></i>
                                  </span>
                              </div>
                          </div>
                              </div>
                            
                        </div>
    
                        <div class="d-flex justify-content-start">
                            <button type="submit" data-id="{{ $employee->id }}" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a class="btn btn-danger ms-2" href="{{ route('karyawan.index') }}"><i class="fa fa-remove"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

      @endif
    </div>
  </div>
</div>
@endsection
@include('adminyofa.karyawan.js.karyawan')
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var eyeIcon = document.getElementById("eye-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.setAttribute("data-feather", "eye-off");
        } else {
            passwordField.type = "password";
            eyeIcon.setAttribute("data-feather", "eye");
        }
        feather.replace();
    }
</script>
  {{-- <script>
    var karyawanStoreUrl = "{{ route('karyawan.store') }}";
    var karyawanUpdateUrl = "{{ route('karyawan.update', $employee->id) }}"; 
    var updatePasswordUrl = "{{ route('karyawan.update.password', $employee->id) }}";
    //delete karyawan.destroy with id
    var karyawanDeleteUrl = "{{ route('karyawan.destroy', '') }}";
</script>
<script src="{{ asset('admin/js/karyawan.js') }}"></script> --}}

@endpush



