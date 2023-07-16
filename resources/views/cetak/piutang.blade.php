@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN PIUTANG</div>
    <hr>
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th width="25%" class="text-center">Nota Penjualan</th>
            <th>Customer</th>
            <th width="15%" class="text-right">Piutang (Rp.)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $v->no_nota }}</td>
                <td>{{ $v->customer }}</td>
                <td class="text-right">{{ number_format($v->sisa_piutang, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="col-xs-9 f-bold" style="text-align: right;">Total Piutang :</div>
        <div class="col-xs-2 f-bold" style="text-align: right;">Rp. {{ number_format($data->sum('sisa_piutang'), 0, ',', '.') }}</div>
    </div>
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
