<div class="appBottomMenu">
    <a href="{{ url('/home') }}" class="item {{ Request::is('home*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>

    <a href="{{ url('absent') }}" class="item {{ Request::is('absent*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="camera-outline"></ion-icon>
            <strong>Absen</strong>
        </div>
    </a>

    <a href="{{ url('cuty') }}" class="item {{ Request::is('cuty*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Cuty</strong>
        </div>
    </a>

    <a href="{{ url('history') }}" class="item {{ Request::is('history*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>History</strong>
        </div>
    </a>

    <a href="{{ url('profile') }}" class="item {{ Request::is('profile*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="person-outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>

<!-- * App Bottom Menu -->

<footer class="text-muted text-center" style="display:none">
   <p>© 2021 - {{ now()->year }} Nama Situs</p>
</footer>
{{-- @include ('layouts.scripts') --}}
</body>
</html>