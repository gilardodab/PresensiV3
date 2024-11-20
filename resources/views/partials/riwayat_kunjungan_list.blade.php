<div class="card mb-1">
    <div class="card-body">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari Presensi">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
</div>
@if($kunjungans->isEmpty())
    <p>Tidak ada data kunjungan untuk periode ini.</p>
@else
    @foreach($kunjungans as $index => $row_kunjungan)
        <div class="transactions item {{ $index >= 4 ? 'd-none load-more' : '' }} mb-1"  data-status="{{ $row_kunjungan->status_kunjungan }}" data-tanggal-kunjungan="{{ $row_kunjungan->kunjungan_tgl }}" data-information="{{ $row_kunjungan->information }}">
            <div class="item">
                <div class="detail">
                    <div>
                        <strong>{{ tgl_ind($row_kunjungan->kunjungan_tgl) }} </strong>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <p class="text-dark">Jam Masuk</p>
                                <p class="text-dark">
                                    <a class="image-link" href="{{ asset('storage/absent/' . $row_kunjungan->picture_in) }}">
                                        <span class="badge badge-success">{{ $row_kunjungan->time_in }}</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <p style="padding-left: 8px;">  {{$row_kunjungan->information}}</p>
                    </div>
                </div>
                <div class="right">
                    {{-- <div class="price text-danger"> - $ 150</div> --}}
                    <button type="button" 
                    class="btn btn-success btn-sm modal-update-history-kunjungan"
                    data-id="{{ $row_kunjungan->kunjungan_id }}"
                    data-status="{{ $row_kunjungan->status_kunjungan }}"
                    data-informasi="{{ $row_kunjungan->information }}"
                    data-tanggal-kunjungan="{{ tgl_ind($row_kunjungan->kunjungan_tgl) }}"
                    data-toggle="modal" 
                    data-target="#modal-show-kunjungan">
                    <i class="fas fa-pencil-alt"></i>
                </button>                
                </div>
            </div>
        </div>
    @endforeach

    <div class="section-footer">
        <a href="#" id="loadMoreBtn" class="btn btn-sm btn-block btn-primary">Load More</a>
    </div>
    <hr>
    <div class="transactions mt-1">
        <div class="item">
            <div class="detail row">
                <div class="row-md-auto ml-1">
                    <p>Sesuai CP : <span class="badge badge-success"></span></p>
                </div>
                <div class="row-md-auto ml-1">
                    <p>Diluar CP : <span class="badge badge-danger"></span></p>
                </div>
            </div>
        </div>
    </div>
@endif
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
    let query = this.value.toLowerCase();
    let items = document.querySelectorAll('.transactions.item');

    items.forEach(function(item) {
        let status = item.getAttribute('data-status').toLowerCase();
        let tanggal = item.getAttribute('data-tanggal').toLowerCase();
        let information = item.getAttribute('data-information').toLowerCase();


        if (status.includes(query) || tanggal.includes(query) || information.includes(query)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
// jQuery untuk menampilkan data lebih banyak
document.getElementById('loadMoreBtn').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelectorAll('.load-more').forEach(function(el) {
        el.classList.remove('d-none'); // Tampilkan data yang disembunyikan
    });
    this.style.display = 'none'; // Sembunyikan tombol setelah semua data ditampilkan
});

// Plugin magnificPopup untuk gambar
$('.image-link').magnificPopup({type:'image'});
</script>
