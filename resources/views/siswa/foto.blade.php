<div>
    @php
$path = Storage::url('uploads/profile/'.$siswa->foto);
@endphp

<img src="{{url($path)}}" class="imaged" alt="" width="480" height="640">
</div>
