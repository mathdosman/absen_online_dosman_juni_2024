<table class="table table-border" >
<thead>
    <tr>
        <td>No</td>
        <td>Kelas</td>
        <td>NISN</td>
        <td>Nama</td>
        <td>Print</td>
    </tr>
</thead>
<tbody>
    @foreach ($cetak as $d)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$d->kode_kelas}}</td>
        <td>{{$d->nisn}}</td>
        <td>{{$d->nama_siswa}}</td>
        <td>
            <form action="/cetak/{{$d->nisn}}/rekapsiswa" target="_blank">
            <button class="btn btn-primary" type="submit">Print</button>
            <input type="hidden" value="{{$bulan}}" id="bulan" name="bulan">
            <input type="hidden" value="{{$tahun}}" id="tahun" name="tahun">
            </form>
        </td>
        </tr>
    @endforeach
</tbody>
</table>
    {{-- <script>
    $(function(){
        $(".print").click(function(e){
                var nisn = $(this).attr('nisn');
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type: 'POST',
                    url:'/cetak/rekapsiswa',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        nisn: nisn,
                        bulan: bulan,
                        tahun: tahun
                    },
                    success:function(respond){

                    }
                });
            });

    });
</script> --}}

