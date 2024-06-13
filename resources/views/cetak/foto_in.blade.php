<div>
@php
    $foto_in = Storage ::url('uploads/absensi/'.$foto_inx->foto_in);
@endphp
<img src="{{url($foto_in) }}" class="image" width="480" height="480" alt="foto_in">
</div>
