@extends('layouts.masteradmin')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Setting Aplikasi</li>
    </ol>
  </nav>
  @switch(request()->get('op'))
  
      @case(null)
      <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="settingumum-line-tab" data-bs-toggle="tab" data-bs-target="#settingumum" role="tab" aria-controls="settingumum" aria-selected="true">Pengaturan Aplikasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="settingprofile-line-tab" data-bs-toggle="tab" data-bs-target="#settingprofile" role="tab" aria-controls="settingprofile" aria-selected="false">Profile</a>
        </li>
      </ul>
      <div class="tab-content mt-3" id="lineTabContent">
        <div class="tab-pane fade show active" id="settingumum" role="tabpanel" aria-labelledby="settingumum-line-tab">...</div>
        <div class="tab-pane fade" id="settingprofile" role="tabpanel" aria-labelledby="settingprofile-line-tab">...</div>
      </div>
      <section class="content-header">
          <h1>Setting Aplikasi</h1>
          <ol class="breadcrumb">
              <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
              <li class="active">Setting Aplikasi</li>
          </ol>
      </section>

      <section class="content">
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                          <li class="active">
                              <a href="#tab_1" data-toggle="tab" onclick="loadSettingUmum();">Pengaturan Aplikasi</a>
                          </li>
                          <li>
                              <a href="#tab_2" data-toggle="tab" onclick="loadSettingProfile();">Profil</a>
                          </li>
                      </ul>
                      <div class="tab-content">
                          <div id="load">
                          </div>
                      </div>
                      <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
              </div>
          </div>
      </section>
            <script>
            var settingUmumUrl = "{{ route('settings.umum') }}";
            var settingProfileUrl = "{{ route('settings.profile') }}";

            var updateSettingUrl = "{{ route('settings.update') }}";
            var updateProfileUrl = "{{ route('settings.profile') }}";
            // loadSettingUmum();
            loadSettingProfile();
      </script>
      <script src="{{ asset('admin/js/settings.js') }}"></script>
      @break

      @default
      <!-- You can add another section for different 'op' cases here -->

  @endswitch
</div>
{{-- <script>
    function loadSettingUmum(){
    $("#load").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    $("#load").load("");
}

function loadSettingProfile(){
    $("#load").html('<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>');
    $("#load").load("");
}


loadSettingUmum();
</script> --}}

            {{-- <h1>Pengaturan Situs</h1>
            <p>URL: {{ $setting->site_url }}</p>
            <p>Nama: {{ $setting->site_name }}</p>
            <p>Perusahaan: {{ $setting->site_company }}</p>
            <a href="{{ route('settings.edit') }}">Edit Pengaturan</a> --}}
@endsection
