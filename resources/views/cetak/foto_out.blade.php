<div>
@php
    $foto_out = Storage ::url('uploads/absensi/'.$foto_outx->foto_out);
@endphp
<img src="{{url($foto_out) }}" class="image" width="480" height="480" alt="foto_out">
</div>
