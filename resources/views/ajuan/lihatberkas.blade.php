<div>
    {{$berkas->nama_siswa}}
</div>
<div>
    @php
$path = Storage::url('uploads/sid/'.$berkas->doc_sid);
@endphp

<img src="{{url($path)}}" class="imaged" alt="" width="100%" height="100%">
</div>
