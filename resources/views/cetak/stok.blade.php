@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN STOK</div>
    <hr>
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="5%" class="text-center text-body-small">#</th>
            <th width="15%" class="text-center text-body-small ">Kategori</th>
            <th class="text-body-small">Nama</th>
            <th width="9%" class="text-center text-body-small">qty</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td width="5%" class="text-center text-body-small">{{ $loop->index + 1 }}</td>
                <td class="text-center text-body-small">{{ $v->kategori->nama }}</td>
                <td class="text-body-small">{{ $v->nama }}</td>
                <td class="text-center text-body-small">{{ $v->qty }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">
            Surakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">(Admin)</div>
    </div>
@endsection
