@extends('layouts.masteradmin')

@section('content')
<div class="content-wrapper">
  @switch(request()->get('op'))
  
      @case(null)
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
            loadSettingUmum();
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
