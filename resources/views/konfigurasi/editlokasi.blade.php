<form action="/lokasi/{{$lokasi->kode_lokasi}}/update" method="POST" id="frmlokasi" >
    @csrf
    <div class="row">
        <div class="col-12">
            <span class="text-muted ms-1">buat kode lokasi maksimal dengan 3 huruf</span>
                                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-numbers" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
                                </span>
                                <input type="text" value="{{$lokasi->kode_lokasi}}" name="kode_lokasi" id="kode_lokasi" class="form-control text-uppercase" placeholder="Kode Lokasi" maxlength="5" required readonly>
                                </div>
                                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-numbers" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
                                </span>
                                <input type="text" value="{{$lokasi->nama_lokasi}}" name="nama_lokasi" id="nama_lokasi" class="form-control" placeholder="Nama Lokasi" required>
                                </div>
                                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" value="{{$lokasi->titik_lokasi}}" id="titik_lokasi" class="form-control" name="titik_lokasi" placeholder="Latitude,Longitude Lokasi" required>
                                </div>

                                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" value="{{$lokasi->radius}}" id="radius" class="form-control" name="radius" placeholder="Radius" required>
                                </div>
        </div>
    </div>
<div class="row">
    <div class="col modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Simpan Perubahan</button>
</div>
</form>
