
    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="/dashboard" class="item {{request()->is('dashboard') ? 'active':''}}">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="/profile/histori" class="item {{ request()-> is('profile/histori') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>
        {{-- <a href="/presensi/create_lokasi" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a> --}}
        <a href="/ajuan/izin" class="item {{ request()-> is('ajuan/izin') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="medkit-outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="/editprofile" class="item {{ request()-> is('editprofile') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->`
