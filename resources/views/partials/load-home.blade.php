<!-- resources/views/partials/load-home.blade.php -->
<div class="col-6 col-md-3 mb-2">
    <a href="javascript:void(0)" class="item">
        <div class="detail">
            <div class="icon-block text-primary">
                <ion-icon name="log-in"></ion-icon>
            </div>
            <div>
                <strong>Hadir</strong>
                <p>{{ $hadir }} Hari</p>
            </div>
        </div>
    </a>
</div>

<div class="col-6 col-md-3 mb-2">
    <a href="javascript:void(0)" class="item">
        <div class="detail">
            <div class="icon-block text-success">
                <ion-icon name="person"></ion-icon>
            </div>
            <div>
                <strong>Izin</strong>
                <p>{{ $izin }} Hari</p>
            </div>
        </div>
    </a>
</div>

<div class="col-6 col-md-3 mb-2">
    <a href="javascript:void(0)" class="item">
        <div class="detail">
            <div class="icon-block text-secondary">
                <ion-icon name="sad"></ion-icon>
            </div>
            <div>
                <strong>Sakit</strong>
                <p>{{ $sakit }} Hari</p>
            </div>
        </div>
    </a>
</div>

<div class="col-6 col-md-3 mb-2">
    <a href="javascript:void(0)" class="item">
        <div class="detail">
            <div class="icon-block text-danger">
                <ion-icon name="alarm"></ion-icon>
            </div>
            <div>
                <strong>Terlambat</strong>
                <p>{{ $telat }} Hari</p>
            </div>
        </div>
    </a>
</div>
