<form action="/kelas/{{$kelas->kode_kelas}}/update" method="POST" id="frmkelas" >
    @csrf
    <div class="row">
        <div class="col-12">
                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-numbers" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 6h9" /><path d="M11 12h9" /><path d="M12 18h8" /><path d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4" /><path d="M6 10v-6l-2 2" /></svg>
                    </span>
                    <input type="text" readonly value="{{$kelas->kode_kelas}}" name="kode_kelas" id="kode_kelas" class="form-control" placeholder="KELAS">
                    </div>

                    <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                    </span>
                    <input type="text" value="{{$kelas->nama_kelas}}" id="nama_kelas" class="form-control" name="nama_kelas" placeholder="NAMA kelas" required>
                    </div>
        </div>
    </div>
<div class="row">
    <div class="col modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Simpan Perubahan</button>
</div>
</form>
