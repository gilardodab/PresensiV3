@extends('layouts.app')

@section('content')
<div id="appCapsule">
    <div class="section mt-3 text-center">
        <div class="avatar-section">
            <input type="file" class="upload" name="photo" id="avatar" accept=".jpg, .jpeg, .gif, .png" capture="camera">
            <a href="#">
            @if(Auth::user()->photo == '')
                <img src="{{ asset('content/avatar.jpg') }}" alt="image" class="imaged w100 rounded">
            @else
                <img src="{{ asset('storage/photos/' . Auth::user()->photo ) }}" alt="avatar" class="imaged w100 rounded">
            @endif
                <span class="button">
                    <ion-icon name="camera-outline"></ion-icon>
                </span>
            </a>
        </div>
    </div>

    <div class="section mt-2 mb-2">
        <div class="section-title">Profil</div>
        <div class="card">
            <div class="card-body">
                <form id="update-profile">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="nik">No Hp</label>
                            <input type="text" class="form-control" id="employees_code" name="employees_code" value="{{ Auth::user()->employees_code }}" >
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="name">Nama</label>
                            <input type="text" class="form-control" id="employees_name" name="employees_name" value="{{ Auth::user()->employees_name }}" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="position_id">Jabatan</label>
                            <select class="form-control custom-select" name="position_id">
                                @foreach($positions as $rowa)
                                    <option value="{{ $rowa->position_id }}" @if($rowa->position_id == Auth::user()->position_id) selected @endif>
                                        {{ $rowa->position_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="shift_id">Jam Kerja</label>
                            <select class="form-control custom-select" name="shift_id">
                                @foreach($shifts as $rowb)
                                    <option value="{{ $rowb->shift_id }}" @if($rowb->shift_id == Auth::user()->shift_id) selected @endif>
                                        {{ $rowb->shift_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="building_id">Lokasi Penempatan</label>
                            <select class="form-control custom-select" name="building_id">
                                @foreach($buildings as $row)
                                    <option value="{{ $row['building_id'] }}" @if($row['building_id'] == Auth::user()->building_id) selected @endif>
                                        {{ $row['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-purple mr-1 btn-lg btn-block btn-profile">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="section mt-2 mb-2">
        <div class="section-title">Update Password</div>
        <div class="card">
            <div class="card-body">
                <form id="update-password" >
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="employees_email">Kode Pegawai</label>
                            <input type="email" class="form-control" name="employees_email" value="{{ Auth::user()->employees_email }}" style="background:#eeeeee" readonly>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="employees_password">Password baru</label>
                            <input type="password" class="form-control" name="employees_password" id="employees_password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-purple mr-1 btn-lg btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
