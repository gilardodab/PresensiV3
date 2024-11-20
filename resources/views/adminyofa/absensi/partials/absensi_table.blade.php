<div class="table-responsive">
    <table class="table table-bordered table-hover" id="datatable">
      <thead>
        <tr>
          <th class="align-middle" width="20">No</th>
          <th class="align-middle">Nama</th>
          <th class="align-middle">Tanggal</th>
          <th class="align-middle text-center">Scan Masuk</th>
          <th class="align-middle text-center">Foto Masuk</th>
          <th class="align-middle text-center">Scan Keluar</th>
          <th class="align-middle">Status</th>
          <th class="align-middle text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($presences as $key => $presence)
        
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $presence->employee->employees_name }}</td>
            <td>{{format_hari_tanggal($presence->presence_date) }}</td>
            <td class="text-center">{{ $presence->time_in }}</td>
            <td class="text-center picture">
              {{-- @if ($presence->picture_in == NULL) {
                  <img src="{{ asset('storage/absent/' . $presence->picture_in) }}">
              } 
              @else { --}}
                  <a class="image-link" href="{{ asset('storage/absent/' . $presence->picture_in) }}">
                          <img src="{{ asset('storage/absent/' . $presence->picture_in) }}"></a>
                  </td>
            {{-- <td class="text-center">{{ asset('storage/absent/' . $presence->picture_in) }}</td> --}}
            <td class="text-center">{{ $presence->time_out }}</td>
            <td>{{ $presence->information }}</td>
            <td class="text-right">
              <a href="#" class="btn btn-sm btn-info btn-modal" 
                 data-latitude="{{ $presence->latitude_longtitude_in ? explode(',', $presence->latitude_longtitude_in)[0] : '' }}" 
                 data-longitude="{{ $presence->latitude_longtitude_in ? explode(',', $presence->latitude_longtitude_in)[1] : '' }}">
                  Masuk
              </a>
              <a href="#" class="btn btn-sm btn-info btn-modal" 
                 data-latitude="{{ $presence->latitude_longtitude_out ? explode(',', $presence->latitude_longtitude_out)[0] : '' }}" 
                 data-longitude="{{ $presence->latitude_longtitude_out ? explode(',', $presence->latitude_longtitude_out)[1] : '' }}">
                  Pulang
              </a>
          </td>
          
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">Data tidak ditemukan</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Modal for displaying the map -->
<div class="modal fade" id="modal-location" tabindex="-1" aria-labelledby="modalLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title modal-title-name" id="modalLocationLabel">Location Map</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div id="iframe-map"></div>
          </div>
      </div>
  </div>
</div>

  