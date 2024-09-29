@extends('layouts.app')

@section('content')


<!-- App Capsule -->
<div id="appCapsule">
    <div class="section text-center">
        <h1>Mendaftar</h1>
    </div>
    <div class="section mb-5 p-2">
        <form id="form-registrasi" method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="card">
                <div class="card-body pb-1">
                    <!-- NIK -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">NIK</label>
                            <input type="text" class="form-control" id="employees_code" name="employees_code" value="{{ old('employees_code') }}" required>
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Nama</label>
                            <input type="text" class="form-control" id="name" name="employees_name" value="{{ old('employees_name') }}" required>
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="employees_email" value="{{ old('employees_email') }}" required>
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>

                    <!-- Jabatan (Position) -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Jabatan</label>
                            <select class="form-control" name="position_id" id="position_id" required>
                                <option value="">- Pilih -</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Jam Kerja (Shift) -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Jam Kerja</label>
                            <select class="form-control" name="shift_id" id="shift_id" required>
                                <option value="">- Pilih -</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>{{ $shift->shift_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Lokasi (Building) -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Lokasi</label>
                            <select class="form-control" name="building_id" id="building" required>
                                <option value="">- Pilih -</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="employees_password" placeholder="Password baru" required>
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Links -->
            <div class="form-links mt-2">
                <div>
                    <a href="{{ route('login') }}">Sudah punya akun?</a>
                </div>
                {{-- <div><a href="{{ route('password.request') }}" class="text-muted">Lupa Password?</a></div> --}}
            </div>

            <!-- Submit Button -->
            <div class="form-button-group transparent">
                <button type="submit" class="btn btn-danger btn-block btn-lg">Mendaftar</button>
            </div>
        </form>
    </div>
</div>

@endsection
@include('layouts.scripts')
