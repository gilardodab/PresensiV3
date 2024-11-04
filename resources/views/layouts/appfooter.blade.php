<div class="appBottomMenu">
    <a href="{{ url('/home') }}" class="item {{ Request::is('home*') ? 'active' : '' }}">
        <div class="col">
            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 512 512"><path fill="none" stroke="{{ Request::is('home*') ? '#90319a' : 'black' }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M80 212v236a16 16 0 0 0 16 16h96V328a24 24 0 0 1 24-24h80a24 24 0 0 1 24 24v136h96a16 16 0 0 0 16-16V212"/><path fill="none" stroke="{{ Request::is('home*') ? '#90319a' : 'black' }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M480 256L266.89 52c-5-5.28-16.69-5.34-21.78 0L32 256m368-77V64h-48v69"/></svg>
            <strong>Home</strong>
        </div>
    </a>

    <a href="{{ url('absent') }}" class="item {{ Request::is('absent*') ? 'active' : '' }}">
        <div class="col">
            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 512 512"><path fill="none" stroke="{{ Request::is('absent*') ? '#90319a' : 'black' }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32"/><circle cx="256" cy="272" r="80" fill="none"stroke="{{ Request::is('absent*') ? '#90319a' : 'black' }}" stroke-miterlimit="10" stroke-width="32"/><path fill="none" stroke="@Re" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M124 158v-22h-24v22"/></svg>
            <strong>Presensi</strong>
        </div>
    </a>

    <a href="{{ url('cuty') }}" class="item {{ Request::is('cuty*') ? 'active' : '' }}">
        <div class="col">
            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 512 512"><rect width="416" height="384" x="48" y="80" fill="none" stroke="{{ Request::is('cuty*') ? '#90319a' : 'black' }}" stroke-linejoin="round" stroke-width="32" rx="48"/><circle cx="296" cy="232" r="24" fill="black"/><circle cx="376" cy="232" r="24" fill="black"/><circle cx="296" cy="312" r="24" fill="black"/><circle cx="376" cy="312" r="24" fill="black"/><circle cx="136" cy="312" r="24" fill="black"/><circle cx="216" cy="312" r="24" fill="black"/><circle cx="136" cy="392" r="24" fill="black"/><circle cx="216" cy="392" r="24" fill="black"/><circle cx="296" cy="392" r="24" fill="black"/><path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M128 48v32m256-32v32"/><path fill="none" stroke="{{ Request::is('cuty*') ? '#90319a' : 'black' }}" stroke-linejoin="round" stroke-width="32" d="M464 160H48"/></svg>
            <strong>Cuti</strong>
        </div>
    </a>

    <a href="{{ url('history') }}" class="item {{ Request::is('history*') ? 'active' : '' }}">
        <div class="col">
            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24"><g fill="none" stroke="{{ Request::is('history*') ? '#90319a' : 'black' }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"><path d="M8 5H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5.697M18 14v4h4m-4-7V7a2 2 0 0 0-2-2h-2"/><path d="M8 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2m6 13a4 4 0 1 0 8 0a4 4 0 1 0-8 0m-6-7h4m-4 4h3"/></g></svg>
            <strong>Riwayat</strong>
        </div>
    </a>

    <a href="{{ url('profile') }}" class="item {{ Request::is('profile*') ? 'active' : '' }}">
        <div class="col">
            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 512 512"><path fill="none" stroke="{{ Request::is('profile*') ? '#90319a' : 'black' }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96"/><path fill="none" stroke="{{ Request::is('profile*') ? '#90319a' : 'black' }}" stroke-miterlimit="10" stroke-width="32" d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304Z"/></svg>
            <strong>Profil</strong>
        </div>
    </a>
</div>

<!-- * App Bottom Menu -->

<footer class="text-muted text-center" style="display:none">
   <p>© 2021 - {{ now()->year }} E-PRESENSI</p>
</footer>
{{-- @include ('layouts.scripts') --}}
</body>
</html>