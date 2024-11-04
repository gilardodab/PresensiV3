<!-- resources/views/partials/load-home.blade.php -->
<div class="col-6 col-md-3 mb-2">
    <a href="javascript:void(0)" class="item">
        <div class="detail">
            <div class="icon-block text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#000ecc" d="M392 80H232a56.06 56.06 0 0 0-56 56v104h153.37l-52.68-52.69a16 16 0 0 1 22.62-22.62l80 80a16 16 0 0 1 0 22.62l-80 80a16 16 0 0 1-22.62-22.62L329.37 272H176v104c0 32.05 33.79 56 64 56h152a56.06 56.06 0 0 0 56-56V136a56.06 56.06 0 0 0-56-56M80 240a16 16 0 0 0 0 32h96v-32Z"/></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#28a745" d="M332.64 64.58C313.18 43.57 286 32 256 32c-30.16 0-57.43 11.5-76.8 32.38c-19.58 21.11-29.12 49.8-26.88 80.78C156.76 206.28 203.27 256 256 256s99.16-49.71 103.67-110.82c2.27-30.7-7.33-59.33-27.03-80.6M432 480H80a31 31 0 0 1-24.2-11.13c-6.5-7.77-9.12-18.38-7.18-29.11C57.06 392.94 83.4 353.61 124.8 326c36.78-24.51 83.37-38 131.2-38s94.42 13.5 131.2 38c41.4 27.6 67.74 66.93 76.18 113.75c1.94 10.73-.68 21.34-7.18 29.11A31 31 0 0 1 432 480"/></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#6c757d" d="M414.39 97.61A224 224 0 1 0 97.61 414.39A224 224 0 1 0 414.39 97.61M184 208a24 24 0 1 1-24 24a23.94 23.94 0 0 1 24-24m-23.67 149.83c12-40.3 50.2-69.83 95.62-69.83s83.62 29.53 95.71 69.83a8 8 0 0 1-7.82 10.17H168.15a8 8 0 0 1-7.82-10.17M328 256a24 24 0 1 1 24-24a23.94 23.94 0 0 1-24 24"/></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#ff007b" d="M153.59 110.46A21.41 21.41 0 0 0 152.48 79A62.67 62.67 0 0 0 112 64l-3.27.09h-.48C74.4 66.15 48 95.55 48.07 131c0 19 8 29.06 14.32 37.11a20.6 20.6 0 0 0 14.7 7.8c.26 0 .7.05 2 .05a19.06 19.06 0 0 0 13.75-5.89Zm250.2-46.35l-3.27-.1H400a62.67 62.67 0 0 0-40.52 15a21.41 21.41 0 0 0-1.11 31.44l60.77 59.65a19.06 19.06 0 0 0 13.79 5.9c1.28 0 1.72 0 2-.05a20.6 20.6 0 0 0 14.69-7.8c6.36-8.05 14.28-18.08 14.32-37.11c.06-35.49-26.34-64.89-60.15-66.93"/><path fill="#ff007b" d="M256.07 96c-97 0-176 78.95-176 176a175.23 175.23 0 0 0 40.81 112.56l-36.12 36.13a16 16 0 1 0 22.63 22.62l36.12-36.12a175.63 175.63 0 0 0 225.12 0l36.13 36.12a16 16 0 1 0 22.63-22.62l-36.13-36.13A175.17 175.17 0 0 0 432.07 272c0-97-78.95-176-176-176m16 176a16 16 0 0 1-16 16h-80a16 16 0 0 1 0-32h64v-96a16 16 0 0 1 32 0Z"/></svg>
            </div>
            <div>
                <strong>Terlambat</strong>
                <p>{{ $telat }} Hari</p>
            </div>
        </div>
    </a>
</div>
