
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand mt-3">
        <a href="/dosman/dashboardadmin">
          <img src="{{asset('assets/img/favicondosman.png') }}" width="110" height="32" alt="Tabler" class="navbar-brand-image" style="margin-inline: 4px">
          <span>ADMIN</span>
        </a>
      </h1>

      <div class="collapse navbar-collapse" id="sidebar-menu">
        <ul class="navbar-nav pt-lg-3">
          <li class="nav-item">
            <a class="nav-link {{ request()-> is(['dosman/dashboardadmin']) ? 'active text-warning' : ''}}" href="/dosman/dashboardadmin" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
              </span>
              <span class="nav-link-title ">
                Home
              </span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()-> is(['siswa','kelas', 'kegiatan']) ? 'show' : ''}}" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()-> is(['siswa','kelas', 'kegiatan']) ? 'true' : 'false'}}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
              </span>
              <span class="nav-link-title">
                Data Master
              </span>
            </a>
            <div class="dropdown-menu {{ request()-> is(['siswa','kelas', 'kegiatan']) ? 'show' : ''}}">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()-> is(['siswa']) ? 'active text-warning' : ''}}" href="/siswa">
                    Data Siswa
                  </a>

                  <a class="dropdown-item {{ request()-> is(['kelas']) ? 'active text-warning' : ''}}" href="/kelas">
                    Data Kelas
                  </a>

                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()-> is(['cetak/monitoring']) ? 'active text-warning' : ''}}" href="/cetak/monitoring" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart-rate-monitor" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" /><path d="M7 20h10" /><path d="M9 16v4" /><path d="M15 16v4" /><path d="M7 10h2l2 3l2 -6l1 3h3" /></svg>
              </span>
              <span class="nav-link-title">
                Monitoring
              </span>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()-> is(['presensi/izinsakit']) ? 'active text-warning' : ''}}" href="/presensi/izinsakit" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-medical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M10 14l4 0" /><path d="M12 12l0 4" /></svg>
              </span>
              <span class="nav-link-title">
                Ajuan Izin/Sakit
              </span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()-> is(['cetak/laporansiswa','cetak/laporankelas']) ? 'show' : ''}}" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()-> is(['cetak/laporansiswa','cetak/laporankelas']) ? 'true' : 'false'}}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /></svg>
              </span>
              <span class="nav-link-title">
                Laporan
              </span>
            </a>
            <div class="dropdown-menu {{ request()-> is(['cetak/laporansiswa','cetak/laporankelas']) ? 'show' : ''}}">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()-> is(['cetak/laporansiswa']) ? 'active text-warning' : ''}}" href="/cetak/laporansiswa">
                    Rekap Siswa
                  </a>

                  <a class="dropdown-item {{ request()-> is(['cetak/laporankelas']) ? 'active text-warning' : ''}}" href="/cetak/laporankelas">
                    Rekap Kelas
                  </a>

                </div>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()-> is(['konfigurasi/jamkelas','konfigurasi/lokasisekolah']) ? 'show ' : ''}}" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()-> is(['konfigurasi/jamkelas','konfigurasi/lokasisekolah']) ? 'true' : 'false'}}" >
              <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
              </span>
              <span class="nav-link-title">
                Konfigurasi
              </span>
            </a>
            <div class="dropdown-menu {{ request()-> is(['konfigurasi/jamkelas','konfigurasi/jamsekolah']) ? 'show ' : ''}}">
              <div class="dropdown-menu-columns">
                  <div class="dropdown-menu-column">
                  <a class="dropdown-item {{ request()-> is(['konfigurasi/jamsekolah']) ? 'active text-warning' : ''}}" href="/konfigurasi/jamsekolah">
                    Jam Sekolah
                  </a>
                  <a class="dropdown-item {{ request()-> is(['konfigurasi/jamkelas']) ? 'active text-warning' : ''}}" href="/konfigurasi/jamkelas">
                    Jam Kelas
                  </a>
                  <a class="dropdown-item {{ request()-> is(['konfigurasi/lokasi']) ? 'active text-warning' : ''}}" href="/konfigurasi/lokasi">
                    Lokasi dan radius
                  </a>
                  <a class="dropdown-item {{ request()-> is(['konfigurasi/harilibur']) ? 'active text-warning' : ''}}" href="/konfigurasi/harilibur">
                    Hari Libur
                  </a>
                </div>
              </div>
            </div>
        </li>
        <li class="nav-item" style="margin-top: 1rem">
            <a class="nav-link" href="/dosman/proseslogoutadmin" >
                <span class="nav-link-icon d-md-none d-lg-inline-block text-danger"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-power" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6a7.75 7.75 0 1 0 10 0" /><path d="M12 4l0 8" /></svg>
                </span>
            <span class="nav-link-title text-muted">
              LOG_OUT
            </span>
          </a>
        </li>
        </ul>
      </div>
    </div>
  </aside>
